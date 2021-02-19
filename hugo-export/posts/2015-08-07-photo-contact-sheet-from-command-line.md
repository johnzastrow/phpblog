---
title: Photo contact sheet from command line
author: John C. Zastrow
type: post
date: 2015-08-07T19:47:54+00:00
url: /2015/08/07/photo-contact-sheet-from-command-line/
categories:
  - Cywgin
  - Data processing
  - Home and Family
  - Linux

---
Recently I needed to inventory a bunch of equipment at a client so I went armed with camera and took a bunch of pictures and notes and came home. Ultimately what I wanted was one or more files containing thumbnails of each image along with the filename below it to include in the report. I suspected that there was a command line way to do this &#8211; in Windows &#8211; and there is. Through the power of <a href="https://www.cygwin.com/" target="_blank">Cygwin</a> (a surprisingly complete Linux CLI environment that runs on Windows), the magic of <a href="http://studio.imagemagick.org/script/index.php" target="_blank">Imagemagick</a> and the guidance from the post below, I created my own recipe.

<a href="http://blog.patdavid.net/2013/04/using-imagemagick-to-create-contact.html" target="_blank" class="broken_link">http://blog.patdavid.net/2013/04/using-imagemagick-to-create-contact.html</a>

Here is my command line to transform a directory of .jpg files into a few (3 in my case) contact sheets also in jpg format.

<pre>montage -verbose -label '%f' -font Helvetica -pointsize 16 -background '#ffffff' -fill 'black' -tile 3x4 -define jpeg:size=400x400 -geometry 400x400 -auto-orient *.jpg contact-light.jpg</pre>

Read the blog above and Imagemagick docs to explain the switches. I did change a few things in the blog&#8217;s example. I bumped up the resolutions of the images, (and hence the contact sheet) a bit, made it black text on white, bigger font, and limited the images to 3&#215;4 pics per page using the tile options.

Since I used Cygwin on Windows I installed all the Imagemagick utils through the easy to use Cygwin installer, as well as Ghostscript and all the fonts I could find for it.

Below is the result.

[<img loading="lazy" src="http://northredoubt.com/n/wp-content/uploads/2015/08/contact-dark2-2b-214x300.jpg" alt="contact-dark2-2b" width="214" height="300" class="aligncenter size-medium wp-image-875" srcset="http://northredoubt.com/n/wp-content/uploads/2015/08/contact-dark2-2b-214x300.jpg 214w, http://northredoubt.com/n/wp-content/uploads/2015/08/contact-dark2-2b-731x1024.jpg 731w, http://northredoubt.com/n/wp-content/uploads/2015/08/contact-dark2-2b.jpg 1200w" sizes="(max-width: 214px) 100vw, 214px" />][1]

 [1]: http://northredoubt.com/n/wp-content/uploads/2015/08/contact-dark2-2b.jpg