---
 #  Scheduled file copies or directory sync from local directory to FTP server
categories:
  - Linux

---
If you have a remote FTP server that you need to put files into, and you don&#8217;t want to deal with SCP/SFTP passkeys, [lftp][1] (http://lftp.yar.ru/) on the local client machine might be for you. It comes with most linux distros (I found it using yum simply as lftp) and one of its most useful traits is to be able to mirror the remote FTP directory to your local one, and vice versa (through &#8211;reverse mirror). Here&#8217;s some examples:

\# verbosely mirror files from FTP server to local dir. -d to show FTP responses  
lftp -d -u ftpusername,password -e &#8220;mirror &#8211;only-newer &#8211;verbose /home/ftpusername/tmp /home/localusername/tmp&#8221; ftphost.com&

\# more quietly mirror files \*to\* FTP server from local dir.  
lftp -u ftpusername,password -e &#8220;mirror &#8211;reverse &#8211;only-newer /home/localusername/tmp tmp&#8221; ftphost.com&

Notice the ampersand, which sends the command to the background so you don&#8217;t have to keep the terminal window open.

Here are some more links:

<http://www.softpanorama.org/Net/Application_layer/Ftp/lftp.shtml>  
<http://www.linux.com/archive/articles/122169>  
[http://how-to.wikia.com/wiki/How\_to\_use\_lftp\_as\_a\_sftp_client][2]  
<http://www.gsp.com/cgi-bin/man.cgi?section=1&topic=lftp>

 [1]: http://lftp.yar.ru/
 [2]: http://how-to.wikia.com/wiki/How_to_use_lftp_as_a_sftp_client