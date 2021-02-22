#!/bin/bash
# sed -e "/url/d; /type/d" ./example.txt 
# sed -e "s/title:/#/; s/&#8217;/'/" ./example.txt

# -i performs the operation on the file "in place"


find . -name "*.md" -type f -print | xargs sed -e "s/<pre>/<pre><code lang-bash>/"
find . -name "*.md" -type f -print | xargs sed -e "s/</pre>/</pre></code>/"
#  find . -name "*.md" -type f -print | xargs sed -e "s/title:/#/; s/&#8217;/'/" 
