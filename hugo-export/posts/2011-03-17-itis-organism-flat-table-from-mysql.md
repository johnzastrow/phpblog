---
title: ITIS Organism Flat table from MySQL
author: John C. Zastrow
type: post
date: 2011-03-17T20:03:30+00:00
url: /2011/03/17/itis-organism-flat-table-from-mysql/
categories:
  - Uncategorized

---
I need to make a table to look up common (vernacular) names for some organisms. So I imported the USGS ITIS database from text files into MySQL and created this little view. Hopefully this helps someone else.

CREATE ALGORITHM=UNDEFINED DEFINER=\`root\`@\`localhost\` SQL SECURITY DEFINER VIEW \`v\_flat\_table\` AS  
SELECT  
&nbsp; \`taxonomic_units\`.\`tsn\`&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; AS \`tsn\`,  
&nbsp; \`taxonomic\_units\`.\`unit\_ind1\`&nbsp;&nbsp; AS \`unit_ind1\`,  
&nbsp; \`taxonomic\_units\`.\`unit\_name1\`&nbsp; AS \`unit_name1\`,  
&nbsp; \`taxonomic\_units\`.\`unit\_ind2\`&nbsp;&nbsp; AS \`unit_ind2\`,  
&nbsp; \`taxonomic\_units\`.\`unit\_name2\`&nbsp; AS \`unit_name2\`,  
&nbsp; \`taxonomic\_units\`.\`unit\_ind3\`&nbsp;&nbsp; AS \`unit_ind3\`,  
&nbsp; \`taxonomic\_units\`.\`unit\_name3\`&nbsp; AS \`unit_name3\`,  
&nbsp; \`taxonomic\_units\`.\`unit\_ind4\`&nbsp;&nbsp; AS \`unit_ind4\`,  
&nbsp; \`taxonomic\_units\`.\`parent\_tsn\`&nbsp; AS \`parent_tsn\`,  
&nbsp; \`taxonomic\_units\`.\`update\_date\` AS \`update_date\`,  
&nbsp; \`taxon\_unit\_types\`.\`rank\_name\`&nbsp; AS \`rank\_name\`,  
&nbsp; \`vernaculars\`.\`vernacular\_name\` AS \`vernacular\_name\`,  
&nbsp; \`longnames\`.\`completename\`&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; AS \`completename\`  
FROM (((\`taxon\_unit\_types\`  
&nbsp;&nbsp;&nbsp;&nbsp; JOIN \`taxonomic_units\`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ON (((\`taxon\_unit\_types\`.\`rank\_id\` = \`taxonomic\_units\`.\`rank_id\`)  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; AND (\`taxon\_unit\_types\`.\`kingdom\_id\` = \`taxonomic\_units\`.\`kingdom_id\`))))  
&nbsp;&nbsp;&nbsp; LEFT JOIN \`vernaculars\`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ON ((\`vernaculars\`.\`tsn\` = \`taxonomic_units\`.\`tsn\`)))  
&nbsp;&nbsp; LEFT JOIN \`longnames\`  
&nbsp;&nbsp;&nbsp;&nbsp; ON ((\`longnames\`.\`tsn\` = \`taxonomic_units\`.\`tsn\`)))



<div class="zemanta-pixie">
  <img class="zemanta-pixie-img" alt="" src="http://img.zemanta.com/pixy.gif?x-id=1d835071-fa11-8823-a5d7-aee7a0064e95" />
</div>