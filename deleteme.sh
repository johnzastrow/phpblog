#!/bin/bash
echo “hi”

title: / # 

remove line starting "author: John C. Zastrow"
same for type: post
date: 2008-07-06T01:17:21+00:00
same for url: /2008/07/05/automate-your-life/
<pre> to


#!/bin/bash
# find_and_replace.sh

echo "Find and replace in current directory!"
echo "File pattern to look for? (eg '*.txt')"
read filepattern
echo "Existing string?"
read existing
echo "Replacement string?"
read replacement
echo "Replacing all occurences of $existing with $replacement in files matching $filepattern"

find . -type f -name $filepattern -print0 | xargs -0 sed -i '' -e "s/$existing/$replacement/g"
