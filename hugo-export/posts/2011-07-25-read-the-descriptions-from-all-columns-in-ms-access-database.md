---
title: Read the Descriptions from all columns in MS Access database
categories:
  - Database
  - GIS

---
From one of my developers. This VBA (couldn&#8217;t find an approach in .Net) will loop through all the tables and write out the description from all the fields.

&nbsp;

TODO&#8217;s include grabbing descriptions for tables and then tweaking below to create ALTER statements so that the comments can be applied to a server RDBMS after migration from Access (since almost none of the migration utilities I&#8217;ve seen migrate this documentation from Access).

&nbsp;

Option Explicit

[cc lang=&#8217;vb&#8217; ]&#8217;call readAllTables  
Public Function readAllTables()

Dim DB As Database, tbl As TableDef, fld As DAO.Field

Dim RS As Recordset  
Dim Table As String  
Dim allDesc As String

Set DB = CurrentDb()

For Each tbl In DB.TableDefs  
If Left$(tbl.Name, 4) <> &#8220;MSys&#8221; Then  
allDesc = allDesc & vbNewLine & &#8220;Table:&#8221; & tbl.Name  
&#8216; optional code to print all the fields  
On Error Resume Next  
For Each fld In tbl.Fields  
&#8216;Debug.Print fld.Name  
allDesc = allDesc & vbNewLine & fld.Name & &#8220;:&#8221; & fld.Properties(&#8220;Description&#8221;)  
Next fld  
End If  
Next tbl

WriteToATextFile (allDesc)  
End Function

Sub WriteToATextFile(ByVal outputStr)  
&#8216;first set a string which contains the path to the file you want to create.  
&#8216;this example creates one and stores it in the root directory  
Dim MyFile As String  
MyFile = &#8220;c:\&#8221; & &#8220;TableFieldsWithDesc.txt&#8221;  
&#8216;set and open file for output  
Dim fnum As Integer  
fnum = FreeFile()  
Open MyFile For Output As fnum  
&#8216;write project info and then a blank line. Note the comma is required  
Write #fnum, outputStr  
Write #fnum,  
Close #fnum  
End Sub[/cc]