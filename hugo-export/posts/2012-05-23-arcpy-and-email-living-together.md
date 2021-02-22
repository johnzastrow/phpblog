---
title: ArcPy and Email – Living together
categories:
  - Data processing
  - Database
  - GIS

---
The other day I needed to process some data for the whole country and I wanted to get the data out by the next morning. The processing was comprised of two steps in Python and ESRI&#8217;s ArcPy for ArcGIS 10 and each needed to run for several hours. So, instead of sitting waiting for the first to finish, I figured it would be cool if the script would email me when it was done? And, yes it was cool. Below is an example of how to do it. Note that the indents get screwed up by WordPress.

<pre class="lang:python decode:1 " ># Import arcpy and other useful modules

from time import clock
from email.mime.text import MIMEText

## Initialize the script timer, just playing around with timer options to check the speed of the script and each loop
clock()
t0clock = time.clock()
t0time = time.time()
start_pg = clock()

# Initialize a time object to the current data and time
nowStart = time.localtime(time.time())

# Output formatted time
print time.strftime( "%m/%d/%Y %H:%M:%S ", nowStart)

## Wrap all significant processing steps in a try/catch block to
## properly report useful errors need import of traceback

try:
# Set some environment settings

 nowDt = time.localtime(time.time())
 outFile = time.strftime( "%Y_%m_%d_%H-%M-%S ", nowDt) +  "_Processed_Classes.txt "
 arcpy.env.workspace =  "C:\\Users\\john.zastrow\\Documents\\WORKING\\PLACES_FGDB.gdb "

strWs = arcpy.env.workspace
 targetFC = strWs +  "\\merged1km\\imprv_1km_merged "
 renameFC = targetFC + time.strftime( "%Y%m%d_%H%M%S ", nowDt)
 copySrc = strWs +  "\\merged1km\\imprv_1km_base_dont_delete "

## A little filter that can limit inputs for script testing. Replace * with some leading chars or fc names
 fcs = arcpy.ListFeatureClasses( "* ",  "polygon ", "clipped1km ")

## Starts the log file which will write the FCs to a text file
 f = open(outFile, "w ")

######### START RENAME BLOCK #################
 ## Moves the previously created FC to a unique name so that we don't lose info with the next run
 arcpy.Rename_management(targetFC,renameFC)
 ## Report action rename
 nowTime = time.localtime(time.time())
 print renameFC +  " - I just renamed at  " + time.strftime( "%m/%d/%Y %H:%M:%S ", nowTime)
 ######### END RENAME BLOCK #################

######### START COPY BLOCK #################
 ## Copies the empty FC needed by the append function into the target FC name
 arcpy.Copy_management(copySrc,targetFC)
 ## Report action copy
 nowTime = time.localtime(time.time())
 print targetFC +  " - I just copied at  " + time.strftime( "%m/%d/%Y %H:%M:%S ", nowTime)
 ######### END COPY BLOCK #################

# Measure process time then wall time from the initialization above
 print time.clock() - t0clock,  " - seconds process time from timer (script) initialization to rename and copy \n "
 print time.time() - t0time,  " - seconds wall time from timer (script) initialization to rename and copy \n "

# for each feature class in the list of f classes returned above
 for fc in fcs:

 ## Put looped processing steps here:
 print fc +  "\n Feature class processed "

 ## Initialize the loop timer
 start_fc_time = clock()
 t0clock_fc = time.clock()
 t0time_fc = time.time()
 nowTime = time.localtime(time.time())
 print fc +  "  " + time.strftime( "%m/%d/%Y %H:%M:%S ", nowTime)
 ## END Initializing the loop timer

# Iterate all feature classes append (merge) them into one.
# Append needs an existing FC.

######### START APPEND BLOCK #################
 arcpy.Append_management(fc, targetFC)
 ## Report action append
 nowTime = time.localtime(time.time())
 print fc +  " - I just appended at  " + time.strftime( "%m/%d/%Y %H:%M:%S ", nowTime)
 ######### END RENAME BLOCK #################

#Create the output file
 outstr = fc +  " -  " + time.strftime( "%m/%d/%Y %H:%M:%S ", nowTime) +  "\n "

#Write values out to the log file
 f.write(outstr)

## Finish loop timer
 ## Write out processing times inside this loop
 end_fc_time = clock()
 end_pg = clock()
 end_script = clock()
 print  "Your processing chunk took %i seconds " % (end_fc_time - start_fc_time)
 # measure process time then wall time
 overallCPUtime = (time.clock() - t0clock_fc)/60
 overallWalltime = (time.time() - t0time_fc)/60
 print str(overallCPUtime) +  " @ - minutes process time for  " + fc
 print str(overallWalltime) +  " @ - minutes wall time  " + fc
 ## END loop timer

# Close the text file
 minutesRun = (time.time() - t0time)/60
 timerall =  "--------------- \n \n The script took the following minutes:  " + str(minutesRun)
 f.write(timerall)
 f.close()
 # Tell user the name of the file and how long everything took
 print str(outFile) +  " is the file I made for you as a log "
 print str(minutesRun) +  " is how long this script took to run in minutes "

## &lt;Debug block>. Use this in all scripts
except arcpy.ExecuteError:

# Get the tool error messages
 #
 print arcpy.GetMessages(2)

except:

# Get the traceback object
 #
 tb = sys.exc_info()[2]
 tbinfo = traceback.format_tb(tb)[0]

# Concatenate information together concerning the error into a message string
 #
 pymsg =  "PYTHON ERRORS:\nTraceback info:\n " + tbinfo +  "\nError Info:\n " + str(sys.exc_info()[1])
 msgs =  "arcpy ERRORS:\n " + arcpy.GetMessages(2) +  "\n "

# Return python error messages for use in script tool or Python Window
 #
 print pymsg
 print msgs

## &lt;/Debug block>.

## Write out processing times
end_pg = clock()
end_script = clock()
print  "Your script took %i seconds " % end_script
print  "Your processing chunk took %i seconds " % (end_pg - start_pg)

## Write out processing times
## START EMAIL BLOCK. Works for Gmail.
to = 'toemail@gmail.com'
gmail_user = 'from_email@gmail.com'
gmail_pwd = 'from_password'
smtpserver = s.SMTP( "smtp.gmail.com ",587)
smtpserver.ehlo()
smtpserver.starttls()
smtpserver.ehlo
smtpserver.login(gmail_user, gmail_pwd)
header = 'To:' + to + '\n' + 'From: ' + gmail_user + '\n' + 'Subject: I am done ' + '\n'
print header
msg = header + '\n The append has finished \n\n' + 'see ' + outFile
smtpserver.sendmail(gmail_user, to, msg)
print 'done!'
smtpserver.close()

## END EMAIL BLOCK

## Confirm to user that script ran to completion
print  "----------- Done! ---------- "

</pre>

When the script runs, it writes this to the screen (which is kinda sloppy and needs some cleaning)

<pre class="lang:bash decode:1 " >05/25/2012 16:43:19
C:\Users\john.zastrow\Documents\WORKING\PLACES_FGDB.gdb\merged1km\imprv_1km_merged20120525_164319 - I just renamed at 05/25/2012 16:43:30
C:\Users\john.zastrow\Documents\WORKING\PLACES_FGDB.gdb\merged1km\imprv_1km_merged - I just copied at 05/25/2012 16:43:35
16.0980007236  - seconds process time from timer (script) initialization to rename and copy

16.0999999046  - seconds wall time from timer (script) initialization to rename and copy

imprv_1km_AL_Huntsville_city
 Feature class processed
imprv_1km_AL_Huntsville_city 05/25/2012 16:43:35
imprv_1km_AL_Huntsville_city - I just appended at 05/25/2012 16:43:43
Your processing chunk took 7 seconds
0.130130412292 @ - minutes process time for imprv_1km_AL_Huntsville_city
0.130150000254 @ - minutes wall time imprv_1km_AL_Huntsville_city

## &lt;snip>

imprv_1km_VA_Alexandria_city
 Feature class processed
imprv_1km_VA_Alexandria_city 05/25/2012 16:48:21
imprv_1km_VA_Alexandria_city - I just appended at 05/25/2012 16:48:30
Your processing chunk took 8 seconds
0.140454443232 @ - minutes process time for imprv_1km_VA_Alexandria_city
0.140450000763 @ - minutes wall time imprv_1km_VA_Alexandria_city
2012_05_25_16-43-19_Appended_Classes.txt is the file I made for you as a log
5.17063333193 is how long this script took to run in minutes
Your script took 310 seconds
Your processing chunk took 310 seconds
To:mymail@gmail.com
From: mymail@gmail.com
Subject: I am done

done!
----------- Done! ----------

</pre>

And this for the output log &#8220;2012\_05\_25\_16-43-19\_Appended_Classes.txt&#8221;.

<pre class="lang:bash decode:1 " >imprv_1km_AL_Huntsville_city - 05/25/2012 16:43:43
imprv_1km_AL_Birmingham_city - 05/25/2012 16:43:51
imprv_1km_AL_Mobile_city - 05/25/2012 16:43:59
imprv_1km_AL_Montgomery_city - 05/25/2012 16:44:06
imprv_1km_AK_Anchorage_municipality - 05/25/2012 16:44:14
imprv_1km_AZ_Glendale_city - 05/25/2012 16:44:22
imprv_1km_CA_Norwalk_city - 05/25/2012 16:45:30
imprv_1km_CA_Glendale_city - 05/25/2012 16:45:37
imprv_1km_CA_Vallejo_city - 05/25/2012 16:45:45
imprv_1km_FL_Palm_Bay_city - 05/25/2012 16:45:53
imprv_1km_FL_Fort_Lauderdale_city - 05/25/2012 16:46:01

imprv_1km_VA_Alexandria_city - 05/25/2012 16:48:30
---------------

   The script took the following minutes: 5.17063333193

</pre>

And then kindly sends me an email when it&#8217;s done!

BTW, hands down the easiest Python editor I&#8217;ve found (and do love) is <a title="PyScripter Google Code link" href="http://code.google.com/p/pyscripter/" target="_blank">PyScripter</a>.

<figure id="attachment_507" aria-describedby="caption-attachment-507" style="width: 368px" class="wp-caption alignnone">[<img loading="lazy" class="size-full wp-image-507" title="editor_options" src="http://northredoubt.com/n/wp-content/uploads/2012/05/editor_options1.gif" alt="" width="368" height="341" srcset="http://northredoubt.com/n/wp-content/uploads/2012/05/editor_options1.gif 368w, http://northredoubt.com/n/wp-content/uploads/2012/05/editor_options1-300x277.gif 300w, http://northredoubt.com/n/wp-content/uploads/2012/05/editor_options1-323x300.gif 323w" sizes="(max-width: 368px) 100vw, 368px" />][1]<figcaption id="caption-attachment-507" class="wp-caption-text">Add arcPy to the IDE to allow integrations and things like code hints (shown below)</figcaption></figure>

<figure id="attachment_504" aria-describedby="caption-attachment-504" style="width: 517px" class="wp-caption alignnone">[<img loading="lazy" class="size-full wp-image-504" title="arcpy" src="http://northredoubt.com/n/wp-content/uploads/2012/05/arcpy.gif" alt="" width="517" height="209" srcset="http://northredoubt.com/n/wp-content/uploads/2012/05/arcpy.gif 517w, http://northredoubt.com/n/wp-content/uploads/2012/05/arcpy-300x121.gif 300w, http://northredoubt.com/n/wp-content/uploads/2012/05/arcpy-500x202.gif 500w" sizes="(max-width: 517px) 100vw, 517px" />][2]<figcaption id="caption-attachment-504" class="wp-caption-text">Just enter a comma then ArcPy to get PyScripter to see and use what ESRI hath wrought</figcaption></figure>

<figure id="attachment_505" aria-describedby="caption-attachment-505" style="width: 724px" class="wp-caption alignnone">[<img loading="lazy" class="size-full wp-image-505" title="code_hints" src="http://northredoubt.com/n/wp-content/uploads/2012/05/code_hints.gif" alt="" width="724" height="312" srcset="http://northredoubt.com/n/wp-content/uploads/2012/05/code_hints.gif 724w, http://northredoubt.com/n/wp-content/uploads/2012/05/code_hints-300x129.gif 300w, http://northredoubt.com/n/wp-content/uploads/2012/05/code_hints-500x215.gif 500w" sizes="(max-width: 724px) 100vw, 724px" />][3]<figcaption id="caption-attachment-505" class="wp-caption-text">Code hints. If you wrap your code with the try/except blocks as shown above, the debugging output is quite good</figcaption></figure>

 [1]: http://northredoubt.com/n/wp-content/uploads/2012/05/editor_options1.gif
 [2]: http://northredoubt.com/n/wp-content/uploads/2012/05/arcpy.gif
 [3]: http://northredoubt.com/n/wp-content/uploads/2012/05/code_hints.gif