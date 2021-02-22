---
 #  Selecting Date from a Mysql field in specific format
categories:
  - Database

---
joined the site. I needed to get a count of members joining per month,  
so I did this:

<pre>&lt;br /&gt;
AS&lt;br /&gt;
MONTH , count( uid ) AS Users &lt;br /&gt;
FROM gl_users &lt;br /&gt;
GROUP BY MONTH  LIMIT 0 , 30&lt;br /&gt;</pre>

Which resulted in 

SQL result 

MONTH , count( uid ) AS Users  
FROM gl_users  
GROUP BY MONTH LIMIT 0, 30; 

<table border="1" cellpadding="2" cellspacing="0">
  <tr>
    <th>
      MONTH
    </th>
    
    <th>
      Users
    </th>
  </tr>
  
  <tr>
    <td valign="top">
      Apr 2004
    </td>
    
    <td align="right" valign="top">
      41
    </td>
  </tr>
  
  <tr>
    <td valign="top">
      Dec 2003
    </td>
    
    <td align="right" valign="top">
      39
    </td>
  </tr>
  
  <tr>
    <td valign="top">
      Feb 2004
    </td>
    
    <td align="right" valign="top">
      41
    </td>
  </tr>
  
  <tr>
    <td valign="top">
      Jan 2003
    </td>
    
    <td align="right" valign="top">
      3
    </td>
  </tr>
  
  <tr>
    <td valign="top">
      Jan 2004
    </td>
    
    <td align="right" valign="top">
      64
    </td>
  </tr>
  
  <tr>
    <td valign="top">
      Jul 2004
    </td>
    
    <td align="right" valign="top">
      7
    </td>
  </tr>
  
  <tr>
    <td valign="top">
      Jun 2004
    </td>
    
    <td align="right" valign="top">
      53
    </td>
  </tr>
  
  <tr>
    <td valign="top">
      Mar 2004
    </td>
    
    <td align="right" valign="top">
      45
    </td>
  </tr>
  
  <tr>
    <td valign="top">
      May 2004
    </td>
    
    <td align="right" valign="top">
      47
    </td>
  </tr>
  
  <tr>
    <td valign="top">
      Nov 2003
    </td>
    
    <td align="right" valign="top">
      51
    </td>
  </tr>
  
  <tr>
    <td valign="top">
      Oct 2003
    </td>
    
    <td align="right" valign="top">
      1
    </td>
  </tr>
</table>

And here are some more resources that I found.

[  
http://dev.mysql.com/doc/mysql/en/Date\_and\_time_functions.html][1]  
[  
http://www.sitepoint.com/forums/archive/index.php/t-164068][2]

[  
http://www.databasejournal.com/features/mysql/article.php/10897\_2190421\_2][3]

 [2]: http://www.sitepoint.com/forums/archive/index.php/t-164068
 [3]: http://www.databasejournal.com/features/mysql/article.php/10897_2190421_2