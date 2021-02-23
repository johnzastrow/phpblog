---
 #  Importing EPA WQX Domains into MySQL Tables
categories:
  - Data processing
  - Database
  - water quality

---

First I created this table to hold my data (you might need to add more columns).

<pre class="lang:mysql decode:true" title="A basic table to hold the values. You might need to add more columns">CREATE TABLE `wqx21_domains` (
  `DOM_ID` int(11) NOT NULL AUTO_INCREMENT,
  `WQXElementName` varchar(500) DEFAULT NULL,
  `UniqueIdentifier` varchar(500) DEFAULT NULL,
  `Code` varchar(500) DEFAULT NULL,
  `Type` varchar(500) DEFAULT NULL,
  `TribalCode` varchar(500) DEFAULT NULL,
  `LastChangeDate` varchar(500) DEFAULT NULL,
  `Description` varchar(500) DEFAULT NULL,
  `Name` varchar(500) DEFAULT NULL,
  `ContextCode` varchar(500) DEFAULT NULL,
  `QualifierType` varchar(500) DEFAULT NULL,
  `Rank` varchar(500) DEFAULT NULL,
  `ExternalID` varchar(500) DEFAULT NULL,
  `STORETID` varchar(500) DEFAULT NULL,
  `SRSID` varchar(500) DEFAULT NULL,
  `SampleFractionRequired` varchar(500) DEFAULT NULL,
  `PickList` varchar(500) DEFAULT NULL,
  `CASNumber` varchar(500) DEFAULT NULL,
  `CountyFIPSCode` varchar(500) DEFAULT NULL,
  `CountyName` varchar(500) DEFAULT NULL,
  `StateCode` varchar(500) DEFAULT NULL,
  `CREATED_DT` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`DOM_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=52401 DEFAULT CHARSET=utf8</pre>

then run the following bash code from within a directory that looks like below.

<figure id="attachment_657" aria-describedby="caption-attachment-657" style="width: 188px" class="wp-caption aligncenter">[<img loading="lazy" class="size-medium wp-image-657" alt="WQX XML domain file list" src="http://northredoubt.com/n/wp-content/uploads/2013/02/wqx_file_list-188x300.png" width="188" height="300" srcset="http://northredoubt.com/n/wp-content/uploads/2013/02/wqx_file_list-188x300.png 188w, http://northredoubt.com/n/wp-content/uploads/2013/02/wqx_file_list-643x1024.png 643w, http://northredoubt.com/n/wp-content/uploads/2013/02/wqx_file_list.png 820w" sizes="(max-width: 188px) 100vw, 188px" />][1]<figcaption id="caption-attachment-657" class="wp-caption-text">WQX XML domain file list</figcaption></figure>

in the last sed line below, note that you must reset the delimeter to | (or something besides / as you need to escape those chars in the values you need to replace. This is the easiest way I think.

**UPDATE:** the post following this one shows how to <a title="Wget examples" href="http://northredoubt.com/n/2013/02/20/wget-examples/" target="_blank">create the directory of .zip files this script needs</a> with a one-liner using wget.

<pre class="lang:sh decode:true" title="bash script to run through all the .zip files and load them to mysql">#!/bin/sh
clear
# optional stuff for checking output
# echo "I see this many zip files: "
# ls *.zip | wc -l
# echo "and they are: "
# ls *.zip
echo ""
echo ""
echo ""
echo ""

echo "************* START ******************"
pwd
echo ""
for zipper in *.zip
do
echo $zipper
echo ""
mkdir "$zipper"_folder
echo ""

unzip -u $zipper -d "$zipper"_folder
echo ""
echo ""
cd "$zipper"_folder
pwd
# I'm going to just leave these around as the directories are easy to delete later.
cat Results.xml | sed -e 's|WQXElementRowColumn|field|' &gt; Results2.xml
cat Results2.xml | sed -e 's/WQXElementRowColumn&gt;/field&gt;/' &gt; Results3.xml
cat Results3.xml | sed -e 's/colname="/name="/' &gt; Results4.xml
cat Results4.xml | sed -e 's/value="/"&gt;/' &gt; Results5.xml
cat Results5.xml | sed -e 's/" "&gt;/"&gt;/' &gt; Results6.xml
cat Results6.xml | sed -e 's|"&gt;&lt;/field&gt;|&lt;/field&gt;|' &gt; Results7.xml
mysql -uuser -p'password' --local-infile -e "use wqx;LOAD XML LOCAL INFILE 'Results7.xml' INTO TABLE wqx21_domains ROWS IDENTIFIED BY '&lt;WQXElementRow&gt;';"
# rm *.xml
cd ..
echo ""
pwd
echo " ----- DONE ------- "$zipper
done
mysqldump -uuser -p'password' wqx &gt; wqx_lookup_dump.sql</pre>

and you will get a MySQL table with contents as follows

<pre class="lang:default decode:true">+---------------------------------+---------+
| WQXElementName                  | Records |
+---------------------------------+---------+
| ActivityGroupType               |       8 |
| ActivityMedia                   |      16 |
| ActivityMediaSubdivision        |      64 |
| ActivityType                    |     100 |
| AddressType                     |       6 |
| AnalyticalMethod                |    6204 |
| Assemblage                      |      15 |
| BiologicalIntent                |       6 |
| CellForm                        |       5 |
| CellShape                       |      10 |
| Characteristic                  |    3766 |
| CharacteristicPickListValue     |    1747 |
| ContainerColor                  |       7 |
| ContainerType                   |      33 |
| Country                         |      16 |
| County                          |    3292 |
| Detection/QuantitationLimitType |      12 |
| ElectronicAddressType           |       3 |
| FrequencyClassDescriptor        |      65 |
| Habit                           |       9 |
| HorizontalCollectionMethod      |      38 |
| HorizontalReferenceDatum        |      16 |
| MeasurementUnit                 |     335 |
| MethodSpeciation                |      15 |
| MetricType                      |      21 |
| MetricTypeContext               |       3 |
| MonitoringLocationType          |      73 |
| NetType                         |       3 |
| Organization                    |     817 |
| PhoneType                       |      10 |
| ReferenceLocationType           |       4 |
| RelativeDepth                   |      16 |
| ResultDetectionCondition        |       5 |
| ResultLabComment                |      34 |
| ResultMeasureQualifier          |      53 |
| ResultStatisticalBase           |      28 |
| ResultStatus                    |      17 |
| ResultTemperatureBasis          |      19 |
| ResultTimeBasis                 |     106 |
| ResultValueType                 |       5 |
| ResultWeightBasis               |       4 |
| SampleCollectionEquipment       |     177 |
| SampleFraction                  |      24 |
| SampleTissueAnatomy             |      83 |
| SamplingDesignType              |       2 |
| State                           |      68 |
| Taxon                           |   65502 |
| ThermalPreservative             |      20 |
| TimeZone                        |      46 |
| ToxicityTestType                |       4 |
| Tribe                           |    1126 |
| VerticalCollectionMethod        |      28 |
| VerticalReferenceDatum          |      12 |
| Voltinism                       |      10 |
| WellFormationType               |       6 |
| WellType                        |      40 |
+---------------------------------+---------+
56 rows in set (0.92 sec)</pre>

**Other resources:**

<a href="http://stackoverflow.com/questions/8582837/load-xml-local-infile-with-inconsistent-column-names" target="_blank">http://stackoverflow.com/questions/8582837/load-xml-local-infile-with-inconsistent-column-names</a>

<a href="http://blog.mclaughlinsoftware.com/2010/09/26/load-xml-local-infile/" target="_blank">http://blog.mclaughlinsoftware.com/2010/09/26/load-xml-local-infile/</a>

 [1]: http://northredoubt.com/n/wp-content/uploads/2013/02/wqx_file_list.png