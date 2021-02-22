---
title: Check for non-numeric data in mysql
categories:
  - Data processing
  - Database

---
This will list the non-numeric data values in a mysql column.

[cc lang=&#8217;sql&#8217; ]select \* from \`tablename\` where concat(&#8221;,\`columnname\` \* 1) <> \`columnname\`[/cc]

<div class="zemanta-pixie">
  <img class="zemanta-pixie-img" src="http://img.zemanta.com/pixy.gif?x-id=dda9f3a7-b810-8363-8180-8096b9010999" alt="" />
</div>