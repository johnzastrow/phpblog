---
title: Spatialite and Spatial Indexes
categories:
  - Data processing
  - Database
  - GIS
  - Linux
  - Spatialite
  - Uncategorized

---
_This post is part of a series <a title="Example with PHP and Spatialite, part 1" href="http://northredoubt.com/n/2012/01/16/example-with-php-and-spatialite-part-1/" target="_blank">[1]</a>, <a title="Example with PHP and Spatialite, part 2" href="http://northredoubt.com/n/2012/01/17/example-with-php-and-spatialite-part-2/" target="_blank">[2]</a>, <a title="Spatialite and Spatial Indexes" href="http://northredoubt.com/n/2012/01/18/spatialite-and-spatial-indexes/" target="_blank">[3]</a>, <a title="Spatialite Speed Test" href="http://northredoubt.com/n/2012/01/20/spatialite-speed-test/" target="_blank">[4]</a>_

Tonight I continued dabbling with my little project and experimenting with spatial indexes in Spatialite. I quickly realized that while using indexes benefitted the queries, the questions were too easy and the queries were finishing very quickly regardless of using indexes or not (nice problem to have). Therefore, the benefits of using the indexes were being swamped out by little errors in timings.

So, I made a bigger dataset. As shown below, the number of features I&#8217;m testing against went from 183 to 2429. You&#8217;d think that would be enough, but stay tuned&#8230;

<figure id="attachment_317" aria-describedby="caption-attachment-317" style="width: 300px" class="wp-caption alignnone">[<img loading="lazy" class="size-medium wp-image-317" title="Bigger sheds" alt="Bigger sheds" src="http://northredoubt.com/n/wp-content/uploads/2012/01/biggersheds-300x196.png" width="300" height="196" srcset="http://northredoubt.com/n/wp-content/uploads/2012/01/biggersheds-300x196.png 300w, http://northredoubt.com/n/wp-content/uploads/2012/01/biggersheds-458x300.png 458w, http://northredoubt.com/n/wp-content/uploads/2012/01/biggersheds.png 729w" sizes="(max-width: 300px) 100vw, 300px" />][1]<figcaption id="caption-attachment-317" class="wp-caption-text">A bigger, badder testing dataset. Note the previous data set at 183 features (purple) and the much larger count of features in the new, blue polys.</figcaption></figure>

So, armed with this larger dataset I proceeded to test sensitivity to using indexes.


## The Original Query

So here is the original query.

<pre class="lang:default decode:true ">SELECT HU_12_NAME FROM huc12
WHERE ST_Contains(Geometry, MakePoint(-70.250,43.802)) = 1</pre>

&nbsp;


<figure id="attachment_316" aria-describedby="caption-attachment-316" style="width: 300px" class="wp-caption alignnone">[<img loading="lazy" class="size-medium wp-image-316 " title="Timings without index" alt="Timings without index" src="http://northredoubt.com/n/wp-content/uploads/2012/01/noindex-300x101.png" width="300" height="101" srcset="http://northredoubt.com/n/wp-content/uploads/2012/01/noindex-300x101.png 300w, http://northredoubt.com/n/wp-content/uploads/2012/01/noindex-500x168.png 500w, http://northredoubt.com/n/wp-content/uploads/2012/01/noindex.png 524w" sizes="(max-width: 300px) 100vw, 300px" />][2]<figcaption id="caption-attachment-316" class="wp-caption-text">Timings without index</figcaption></figure>

I&#8217;m also including the explain plans here. Obviously without an index the query has to do a full scan of the table to figure out which records it needs. Scans are bad. Scans of many records are very bad.

<figure id="attachment_322" aria-describedby="caption-attachment-322" style="width: 300px" class="wp-caption alignnone">[<img loading="lazy" class="size-medium wp-image-322" title="Explain plan with no index" alt="Explain plan with no index" src="http://northredoubt.com/n/wp-content/uploads/2012/01/explain_noindex-300x61.png" width="300" height="61" srcset="http://northredoubt.com/n/wp-content/uploads/2012/01/explain_noindex-300x61.png 300w, http://northredoubt.com/n/wp-content/uploads/2012/01/explain_noindex-500x103.png 500w, http://northredoubt.com/n/wp-content/uploads/2012/01/explain_noindex.png 518w" sizes="(max-width: 300px) 100vw, 300px" />][3]<figcaption id="caption-attachment-322" class="wp-caption-text">Explain plan with no index</figcaption></figure>

## A Better Query

Ok, so to scan less you need to do some filtering based on something to reduce the records you&#8217;re talking to. In this case, we use the bboxes from the index tables to grab a more limited set of features to actually perform the more intensive ST_Contains test with just to make sure the point ACTUALLY falls within the set of polygons the BBOX suggests.

<pre class="lang:default decode:true">SELECT HU_12_NAME FROM huc12
WHERE ST_Contains(Geometry, MakePoint(-70.250,43.802))
AND
ROWID IN (
SELECT pkid from idx_huc12_Geometry where xmin &lt; -69 and xmax &gt; -71)</pre>

&nbsp;

OK, now I was getting ~1.1 seconds pretty reliably. Yep, that&#8217;s detectable change between the two queries. So, we have enough records to see the benefits of the improved queries. This was an improvement, but not enough.

<figure id="attachment_315" aria-describedby="caption-attachment-315" style="width: 300px" class="wp-caption alignnone">[<img loading="lazy" class="size-medium wp-image-315" title="Timings with some index" alt="Timings with some index" src="http://northredoubt.com/n/wp-content/uploads/2012/01/betterindex-300x144.png" width="300" height="144" srcset="http://northredoubt.com/n/wp-content/uploads/2012/01/betterindex-300x144.png 300w, http://northredoubt.com/n/wp-content/uploads/2012/01/betterindex.png 483w" sizes="(max-width: 300px) 100vw, 300px" />][4]<figcaption id="caption-attachment-315" class="wp-caption-text">Timings with some index</figcaption></figure>

The explain plan gets better. We see the filtering and while we&#8217;re scanning, it&#8217;s more manageable.

<figure id="attachment_321" aria-describedby="caption-attachment-321" style="width: 300px" class="wp-caption alignnone">[<img loading="lazy" class="size-medium wp-image-321" title="Explain plan with some index" alt="Explain plan with some index" src="http://northredoubt.com/n/wp-content/uploads/2012/01/explain_better-300x119.png" width="300" height="119" srcset="http://northredoubt.com/n/wp-content/uploads/2012/01/explain_better-300x119.png 300w, http://northredoubt.com/n/wp-content/uploads/2012/01/explain_better-500x199.png 500w, http://northredoubt.com/n/wp-content/uploads/2012/01/explain_better.png 525w" sizes="(max-width: 300px) 100vw, 300px" />][5]<figcaption id="caption-attachment-321" class="wp-caption-text">Explain plan with some index</figcaption></figure>

##  Best Query


&nbsp;

<pre class="lang:default decode:true ">SELECT HU_12_NAME FROM huc12
WHERE ST_Contains(Geometry, MakePoint(-70.250,43.802)) = 1
AND ROWID IN (
SELECT ROWID
FROM SpatialIndex
WHERE f_table_name = 'huc12'
AND search_frame = MakePoint(-70.250,43.802));</pre>

&nbsp;

&nbsp;

And here we see true magic. The original query with no indexes ran for 1.9 seconds. Some index sped things up to 1.1. Now, hold on to your socks, Sandro&#8217;s more proper query comes in at 0.16 seconds. That kind of performance really gives me hope.

<figure id="attachment_314" aria-describedby="caption-attachment-314" style="width: 300px" class="wp-caption alignnone">[<img loading="lazy" class="size-medium wp-image-314" title="Timings with best index" alt="Timings with some index" src="http://northredoubt.com/n/wp-content/uploads/2012/01/bestindex-300x142.png" width="300" height="142" srcset="http://northredoubt.com/n/wp-content/uploads/2012/01/bestindex-300x142.png 300w, http://northredoubt.com/n/wp-content/uploads/2012/01/bestindex-500x237.png 500w, http://northredoubt.com/n/wp-content/uploads/2012/01/bestindex.png 513w" sizes="(max-width: 300px) 100vw, 300px" />][6]<figcaption id="caption-attachment-314" class="wp-caption-text">Timings with some index</figcaption></figure>

We don&#8217;t learn too much more from the explain plan. But hey, who needs to ask more questions of that kind of speed up.

<figure id="attachment_320" aria-describedby="caption-attachment-320" style="width: 300px" class="wp-caption alignnone">[<img loading="lazy" class="size-medium wp-image-320" title="Explain plan with optimal virtual index" alt="Explain plan with optimal virtual index" src="http://northredoubt.com/n/wp-content/uploads/2012/01/explain_best-300x127.png" width="300" height="127" srcset="http://northredoubt.com/n/wp-content/uploads/2012/01/explain_best-300x127.png 300w, http://northredoubt.com/n/wp-content/uploads/2012/01/explain_best-500x212.png 500w, http://northredoubt.com/n/wp-content/uploads/2012/01/explain_best.png 525w" sizes="(max-width: 300px) 100vw, 300px" />][7]<figcaption id="caption-attachment-320" class="wp-caption-text">Explain plan with optimal virtual index</figcaption></figure>

That was fun. What does it do when stuck into PHP?

First let&#8217;s just do the same old &#8220;no index&#8221; version.

<figure id="attachment_335" aria-describedby="caption-attachment-335" style="width: 300px" class="wp-caption alignnone">[<img loading="lazy" class="size-medium wp-image-335" title="PHP page with more features and no index in query" alt="PHP page with more features and no index in query" src="http://northredoubt.com/n/wp-content/uploads/2012/01/php_noindex-300x220.png" width="300" height="220" srcset="http://northredoubt.com/n/wp-content/uploads/2012/01/php_noindex-300x220.png 300w, http://northredoubt.com/n/wp-content/uploads/2012/01/php_noindex-407x300.png 407w, http://northredoubt.com/n/wp-content/uploads/2012/01/php_noindex.png 511w" sizes="(max-width: 300px) 100vw, 300px" />][8]<figcaption id="caption-attachment-335" class="wp-caption-text">PHP page with more features and no index in query</figcaption></figure>

About 2.5 seconds on average. No surprises there.

How about with some spatial index.

<figure id="attachment_334" aria-describedby="caption-attachment-334" style="width: 719px" class="wp-caption alignnone">[<img loading="lazy" class="size-full wp-image-334" title="PHP page with more features and some spatial index in query" alt="PHP page with more features and some spatial index in query" src="http://northredoubt.com/n/wp-content/uploads/2012/01/php_someindex.png" width="719" height="365" srcset="http://northredoubt.com/n/wp-content/uploads/2012/01/php_someindex.png 719w, http://northredoubt.com/n/wp-content/uploads/2012/01/php_someindex-300x152.png 300w, http://northredoubt.com/n/wp-content/uploads/2012/01/php_someindex-500x253.png 500w" sizes="(max-width: 719px) 100vw, 719px" />][9]<figcaption id="caption-attachment-334" class="wp-caption-text">PHP page with more features and some spatial index in query</figcaption></figure>

&nbsp;

About 1.8 seconds on average. Shaved quite a bit off, but we&#8217;re still way over the 1 second goal. How about with Sandro&#8217;s query?

<figure id="attachment_333" aria-describedby="caption-attachment-333" style="width: 744px" class="wp-caption alignnone">[<img loading="lazy" class="size-full wp-image-333" title="PHP page with more features and best spatial index in query" alt="PHP page with more features and best spatial index in query" src="http://northredoubt.com/n/wp-content/uploads/2012/01/php_bestindex.png" width="744" height="407" srcset="http://northredoubt.com/n/wp-content/uploads/2012/01/php_bestindex.png 744w, http://northredoubt.com/n/wp-content/uploads/2012/01/php_bestindex-300x164.png 300w, http://northredoubt.com/n/wp-content/uploads/2012/01/php_bestindex-500x273.png 500w" sizes="(max-width: 744px) 100vw, 744px" />][10]<figcaption id="caption-attachment-333" class="wp-caption-text">PHP page with more features and best spatial index in query</figcaption></figure>

Cool. We&#8217;re below the 1 second mark. I even saw a 0.7 second timing every so often. But, we&#8217;re very close to 1 second, so I&#8217;m starting to sweat a little. But wait, there&#8217;s more. I&#8217;ve still got those little filler queries happening on the page, and one of them is a bulky SELECT DISTINCT which is going to scan my larger dataset now. So, what happens when we get rid the crud?

<figure id="attachment_332" aria-describedby="caption-attachment-332" style="width: 744px" class="wp-caption alignnone">[<img loading="lazy" class="size-full wp-image-332" title="PHP page with more features, best spatial index, and extra queries removed" alt="PHP page with more features, best spatial index, and extra queries removed" src="http://northredoubt.com/n/wp-content/uploads/2012/01/php_simple_best.png" width="744" height="282" srcset="http://northredoubt.com/n/wp-content/uploads/2012/01/php_simple_best.png 744w, http://northredoubt.com/n/wp-content/uploads/2012/01/php_simple_best-300x113.png 300w, http://northredoubt.com/n/wp-content/uploads/2012/01/php_simple_best-500x189.png 500w" sizes="(max-width: 744px) 100vw, 744px" />][11]<figcaption id="caption-attachment-332" class="wp-caption-text">PHP page with more features, best spatial index, and extra queries removed</figcaption></figure>

Yes! At 0.26 seconds we&#8217;re way below 1 second again. Phew! What about the original query? What happens when we remove the cruft from that page but still use the un-optimized query?

<figure id="attachment_338" aria-describedby="caption-attachment-338" style="width: 514px" class="wp-caption alignnone">[<img loading="lazy" class="size-full wp-image-338" title="PHP page with no index, but extra queries removed" alt="PHP page with no index, but extra queries removed" src="http://northredoubt.com/n/wp-content/uploads/2012/01/php_simple_no_index.png" width="514" height="246" srcset="http://northredoubt.com/n/wp-content/uploads/2012/01/php_simple_no_index.png 514w, http://northredoubt.com/n/wp-content/uploads/2012/01/php_simple_no_index-300x143.png 300w, http://northredoubt.com/n/wp-content/uploads/2012/01/php_simple_no_index-500x239.png 500w" sizes="(max-width: 514px) 100vw, 514px" />][12]<figcaption id="caption-attachment-338" class="wp-caption-text">PHP page with no index, but extra queries removed</figcaption></figure>

1.9 seconds. Some improvement from the first page, but not where we need it. No worries, we&#8217;re moving on!

 [1]: http://northredoubt.com/n/wp-content/uploads/2012/01/biggersheds.png
 [2]: http://northredoubt.com/n/wp-content/uploads/2012/01/noindex.png
 [3]: http://northredoubt.com/n/wp-content/uploads/2012/01/explain_noindex.png
 [4]: http://northredoubt.com/n/wp-content/uploads/2012/01/betterindex.png
 [5]: http://northredoubt.com/n/wp-content/uploads/2012/01/explain_better.png
 [6]: http://northredoubt.com/n/wp-content/uploads/2012/01/bestindex.png
 [7]: http://northredoubt.com/n/wp-content/uploads/2012/01/explain_best.png
 [8]: http://northredoubt.com/n/wp-content/uploads/2012/01/php_noindex.png
 [9]: http://northredoubt.com/n/wp-content/uploads/2012/01/php_someindex.png
 [10]: http://northredoubt.com/n/wp-content/uploads/2012/01/php_bestindex.png
 [11]: http://northredoubt.com/n/wp-content/uploads/2012/01/php_simple_best.png
 [12]: http://northredoubt.com/n/wp-content/uploads/2012/01/php_simple_no_index.png