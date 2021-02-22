---
 #  Spatialite wishlist for 2013
categories:
  - Data processing
  - Database
  - GIS
  - Spatialite
  - Uncategorized

---
The Spatialite project and its family of products is progressing and gaining a larger following by the day. Growth seems to be coming from its apparent target audience &#8211; mobile developers (though I rely on it for desktop use). This is likely to only snowball as Spatialite acceptance increases and it gets woven into increasing numbers of projects and  workflows. Sandro and Brad and maybe a small handful of others are making methodical and incremental progress advancing it. It&#8217;s quality is improving and its features and capabilities are growing like the weeds in my yard. But, Spatialite and its team can be so much more. So here is my wish list based on more than two years of watching and using it.

First let me say that I&#8217;m truly writing in the spirit of constructive observations. I don&#8217;t want to be critical of the current project members as their patience and generosity are amazing. But beyond that, Sandro is the father of the project and,of course Spatialite is his to run any way he wishes.

So here are some wishlist items.

**Simpler, default use of spatial indexes in queries:** Right now in Spatialite you have to use sub-queries to use spatial indexes in your queries. It&#8217;s not the end of the world, and it does allow you a certain flexibility in crafting your code. But, they are easy to screw up and frankly it&#8217;s more typing for something that you want to do <del>often </del>nearly always. Other spatial DBs just use the indexes by default.

**A GIS GUI that makes full use of the capabilities** &#8211; The core Spatialite offers lots of cool little utility functions (i.e., **<a href="http://www.gaia-gis.it/gaia-sins/spatialite-sql-4.0.0.html#p10" target="_blank" class="broken_link">SanitizeGeometry, ST_IsValid, etc.</a>) ** in addition to the standard geoprocessing ones and they accessible from the command line via SQL statements. Now I&#8217;m fine with the command line, but I haven&#8217;t done GIS with flashing cursor in years.  Sandro provides a nice little set of GUI tools, and I think he likes writing them. But they don&#8217;t expose ALL of the latest functions as I&#8217;m sure these take time to include. I&#8217;d rather the vast array of libspatialite functions get exposed through a single, go-to application instead of having to keep a few GUI utilities laying around or bounce between flashing cursors and mice. So, I&#8217;m really hoping for GUI controls in Qgis that will let me harness all of the power in Spatialite functions from within Qgis without having to keep both Qgis and a terminal open. This is going to get even more critical if the Geopackage spec gets cleaned up and goes anywhere.

**Larger Developer Community:** Spatialite really seems to be a labor of love to Sandro &#8211; and it shows with his support of user questions on the support list on <a href="https://groups.google.com/forum/?fromgroups#!forum/spatialite-users" target="_blank">Google Groups</a>. Similarly, development seems to be guided mostly by Sandro&#8217;s needs &#8212; which is fine to an extent. But the development road map lacks transparency &#8211; which is to say that it&#8217;s not missing, just needs some more daylight and/or planning. Users might have some inkling of major new initiatives that Sandro and Brad are working on when they have the time to write about them in an email or a wiki entry. But there is no complete public road map, no true work log, and mostly we hear about new tweaks such as SQL functions only after they are released. You can kinda see what HAS happened if you watch the <a href="https://www.gaia-gis.it/fossil/libspatialite/timeline" target="_blank">Fossil timelines</a> &#8211; But this isn&#8217;t ideal. So, I am hopeful that this project will mature into one having a larger, interactive, transparent, diverse and functional developer community and that Sandro can and will allow other minds to influence the direction that future Spatialite development takes. In short, I think _<span style="text-decoration: underline;">the guys need help with the standard mechanics of OSS projects (development, documentation, outreach, etc.)</span>._


**Better support for MS VC++ in general and non-manual support for system.data.sqlite: **Sandro and the other guys don&#8217;t like doing Windows. I get it. But people really want to be able get Spatialite happily integrated into their .Net development life &#8211; and these are people who don&#8217;t do ./configure \ make \ make install in their sleep. Sandro has posted notes for working with his project files in Visual Studio, but they frighten Microsoft-only folks. Sebastian* found agony with this and created some additional work (<a href="https://bitbucket.org/mayastudios" target="_blank">https://bitbucket.org/mayastudios</a>) to help him do Windows. But I hope that someone steps up to help the current project members maintain parallel builds and projects targeted at better supporting Windows and other platforms. Sandro and Brad maintain the core libs and do what they can to assist integration with other platforms. So some dedicated downstream maintainers for other platforms and builds are really needed.

**Less is more:** Honestly, Spatialite already has just about every spatial functions a person could want for 80% of their needs. It&#8217;s really quite complete that way. So, my personal wish is that the supporting documentation, utilities, interfaces, linkages and platforms get a little more attention now. But I think now that we are the reference implementation for vectors in the new OGC Geopackage spec more energy will likely be diverted there instead of shoring up these existing ancillary things &#8211; at least until new developers and helpers get involved.

So these are just a few items on my wishlist. We&#8217;ll see if the future takes us to places where they addressed or become irrelevant.

&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;-


  * The repository **_spatialite-lib-windows_** just compiles the native (unmanaged) &#8220;spatialite.dll&#8221; &#8211; along with &#8220;sqlite.dll&#8221;, if you need it. The same is true for the<span style="text-decoration: underline;"><strong> &#8220;spatialite-lib-android&#8221;</strong> </span>(former &#8220;spatialite-android-lib&#8221;) repository, just for Android. The repository &#8220;spatialite-android-java&#8221; (former &#8220;spatialite-android&#8221;) is obsolete.
  * SQLite.Net started as a port of the Java SQLite bindings with the goal to allow it to be used cross-platform. At the time of writing, I was fairely new to SQLite and I couldn&#8217;t get &#8220;system.data.sqlite&#8221; compiled (AFAIK). So I sticked with my own implementation.
  * <div>
      <div>
        >Does <a href="http://sqlite.net/" target="_blank">sqlite.net</a> let me call spatialite more directly through .Net?
      </div>
      
      <div>
        <span style="font-family: arial, sans-serif;">       &#8211; No, that&#8217;s what <a href="https://bitbucket.org/mayastudios/spatialite.net" target="_blank" class="broken_link">spatialite.net</a> is for. It allows you to directly bind/obtain geometry objects (provided by NTS) to/from the database.</span>
      </div>
    </div>
    
    <div>
      <div>
      </div>
    </div>
    
    <div>
    </div>

  *  If you&#8217;re just looking for the Spatialite binaries, you can download them here: <a href="https://bitbucket.org/mayastudios/files/src" target="_blank" class="broken_link">https://bitbucket.org/<wbr />mayastudios/files/src</a>
  * Sebastian just recently posted this to the Spatialite Google Group for those needing Spatialite on Windows. 
      * &#8220;Just a quick note for people looking for a way to compile Spatialite 4 on Windows (with Visual Studio) or Android. I&#8217;ve compiled project files/build files for both and placed them in public Mercurial repositories: 
          * For Windows: <a href="https://bitbucket.org/mayastudios/spatialite-lib-windows" target="_blank" class="broken_link">https://bitbucket.org/<wbr />mayastudios/spatialite-lib-<wbr />windows</a>  
            $ hg clone <a href="https://bitbucket.org/mayastudios/spatialite-lib-windows" target="_blank" class="broken_link">https://bitbucket.org/<wbr />mayastudios/spatialite-lib-<wbr />windows</a>
          * For Android: <a href="https://bitbucket.org/mayastudios/spatialite-lib-android" target="_blank" class="broken_link">https://bitbucket.org/<wbr />mayastudios/spatialite-lib-<wbr />android</a>  
            $ hg clone <a href="https://bitbucket.org/mayastudios/spatialite-lib-android" target="_blank" class="broken_link">https://bitbucket.org/<wbr />mayastudios/spatialite-lib-<wbr />android</a>
        
        You need <a href="http://mercurial.selenic.com/" target="_blank">Mercurial</a> (hg) to check out these repositories. You cannot just download them, as they contain sub repositories that won&#8217;t be included in the download.
        
        If you&#8217;re just interested in the resulting binary, you can download them here:
        
        <a href="https://bitbucket.org/mayastudios/files/src" target="_blank" class="broken_link">https://bitbucket.org/<wbr />mayastudios/files/src</a>&#8220;</li> </ul> </li> 
        
          * Also see: **[SpatiaLite-Users] SpatiaLite v4 with c# on VS2012. ** <p style="display: inline !important;">
              <strong><em id="__mceDel">Vittorio Maniezzo via googlegroups.com. </em></strong>
            </p>
            
            <p style="display: inline !important;">
              <strong><em id="__mceDel">Apr 10, 2013</em></strong>
            </p>
        
          * To spatialite-users.  
            As a couple of people asked me for this, maybe there are more out there interested.  
            I uploaded on my server (at <a href="http://astarte.csr.unibo.it/snippets/testSpatialite4.zip" target="_blank">http://astarte.csr.unibo.it/snippets/testSpatialite4.zip </a>)  
            a very bare VS2012 c# project using SL 4.0.0. It&#8217;s not that much complete: the 32 bit version works fine, the 64 bit not yet. But in the near future I won&#8217;t have time to work on this, so maybe someone can help.  
            Cheers,  
            Vittorio</ul> 
        
        &nbsp;