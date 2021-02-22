---
title: The power of xargs
categories:
  - Linux

---
Excerpted (stolen) from 

xargs is your friend. Using xargs, you can pull off feats of greatness  
and not have to write a script to do it. xargs can take care of things  
right on the command line. Though I focus mainly on files in this  
article (it&#8217;s what I use it for almost exclusively), it&#8217;s important to  
remember that xargs acts on standard input, which could mean lines  
manage to point in its direction.

$ > rpm -qa | grep mozilla | xargs -n1 -p rpm -e &#8211;nodeps 

What this says in English, is &#8220;Using RPM, query all (-qa) packages,  
look for mozilla in the package name, and send the results one at a  
time (-n1), to RPM&#8217;s uninstall command, and I don&#8217;t care about  
dependencies, thank you very much (&#8220;rpm -e &#8211;nodeps&#8221;). Also, in case  
there&#8217;s something that contains the word &#8220;mozilla&#8221; that I DON&#8217;T want  
erased, prompt me (-p) before uninstalling.&#8221; The above command saves  
you from having to manually list the packages containing the string  
&#8220;mozilla,&#8221; then manually running separate &#8220;rpm -e&#8221; commands against  
them one at a time. 


This finds all the mp3z on my entire drive and puts &#8217;em all in a tar  
file, and then I can untar them wherever I want 🙂 I actually could&#8217;ve  
piped that xargs &#8220;tar&#8221; line into a &#8220;tar xvzf&#8221; line to automatically  
to use a custom directory structure that I wanted to preserve. You get  
all the files that belong to you, tarring them and sending the tar to a  
backup somewhere, so it does have legitimate use. 

$> ls *.mp3 | xargs -n1 -i cp {} backup/. 

This command takes all of the MP3 files in the current directory, and  
feeds them one at a time (-n1) to the cp command, where the file  
didn&#8217;t specify a string with &#8220;-i.&#8221; I don&#8217;t think I&#8217;ve ever had to. The  
default string that xargs will look to replace when using the -i flag  
or you start using xargs in scripts, there are a couple of useful  
troubleshooting flags you may find helpful if you run into issues. One,  
the -p flag, will prompt you for a yes or no before executing a command  
on anything. The other, which is a real life saver, is &#8220;-t,&#8221; and it  
does NOT prompt you for a yes or no (unless you use it with -p), but it  
will output the command it&#8217;s trying to execute, so if something isn&#8217;t  
quite right, you&#8217;ll be able to spot it right away. Comments:

$ > rpm -qa | grep mozilla | xargs -n1 -p rpm -e &#8211;nodeps 

How about:

rpm -e &#8211;nodeps \`rpm -qa|grep mozilla\` 

or if you want a prompt:

for pkg in \`rpm -qa\`  
do  
echo &#8220;Remove package $pkg? (y/n)&#8221;  
read ans  
if [ &#8220;$ans&#8221; == &#8220;y&#8221; ]; then  
rpm -e &#8211;nodeps $pkg  
fi  
done 

Far clearer. The use for xargs is cases where you want to use tools  
(such as GNU Grep) which have limits on the amount of input they can  
take. For example:


might be too much for grep to cope with;

> ls *.mp3 | xargs -n1 -i cp {} backup/.