---
title: Run queries in sequence in Access
author: John C. Zastrow
type: post
date: 2011-04-22T20:31:04+00:00
url: /2011/04/22/run-queries-in-sequence-in-access/
categories:
  - Uncategorized

---
I&#8217;ve gotten so used to using &#8220;real&#8221; databases, that I find myself frustrated when I have to switch back to Microsoft Access. But, hey, it&#8217;s good for a lot of things.

Annoyingly, if you just want to run some SQL back-to-back, or one after another, you have to call it in VBA. So, create a module and do something silly like.

Sub update_results()  
DoCmd.SetWarnings False  
DoCmd.OpenQuery &#8220;q_1-4000&#8221;  
DoCmd.OpenQuery &#8220;q_4001-8000&#8221;  
DoCmd.OpenQuery &#8220;q\_the\_rest&#8221;  
DoCmd.SetWarnings True  
End Sub

The SetWarnings stuff stops pop ups from annoying you about the fact that you are going to update some data. 

<img style="max-width: 800px;" src="http://northredoubt.com/n/wp-content/uploads/2011/04/access_queries.png" /> 

<div class="zemanta-pixie">
  <img class="zemanta-pixie-img" alt="" src="http://img.zemanta.com/pixy.gif?x-id=5778cd59-3f13-8601-a10b-6b57c11b7760" />
</div>