#!/bin/bash
set vx
# sed -e "/url/d; /type/d" ./example.txt 
# sed -e "s/title:/#/; s/&#8217;/'/" ./example.txt
# sed -e "s/title:/#/" ./example.txt

# -i performs the operation on the file "in place"


#   find . -name "*.md" -type f -print | xargs sed -i "s/<pre>/<pre><code class=\"language-bash\">/"
find . -name "*.md" -type f -print | xargs sed -e "s/title:/ # /"
find . -name "*.md" -type f -print | xargs sed -e "/url/d; /type/d; /author/d; /date/d"
  find . -name "*.md" -type f -print | xargs sed -e "s/<\/pre>/CLOSE_PRE/"
  find . -name "*.md" -type f -print | xargs sed -e "s|CLOSE_PRE|<\/pre>\<\/code\>|"


#  find . -name "*.md" -type f -print | xargs sed -e "s/title:/#/; s/&#8217;/'/" 
