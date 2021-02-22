---
 #  Use Excel’s MID and FIND to extract characters from varying positions
categories:
  - Data processing

---
Use this to grab the values after a certain value, of the whole string the value doesn&#8217;t exist. The concatenation ensure that the value is always found. The final Len(A1) forces the entire length of the string after the value to be shown regardless of what it it. the final A1 in the formula shows the entire string if the value is not found anywhere in the string.

**IF(FIND(&#8220;.&#8221;,CONCATENATE(A1,&#8221;.&#8221;)) <= LEN(A1), MID(A1, FIND(&#8220;.&#8221;, A1) + 1,LEN(A1)), A1)**

<table border="0" cellspacing="0" cellpadding="0" width="578">
  <colgroup> <col style="mso-width-source: userset; mso-width-alt: 5997; width: 123pt;" width="164"></col> <col style="mso-width-source: userset; mso-width-alt: 15140; width: 311pt;" width="414"></col> </colgroup> <tr style="height: 15.0pt;" height="20" valign="bottom">
    <td class="xl65" style="height: 15.0pt; width: 123pt;" width="164" height="20">
      hhhh.yuuuu
    </td>
    
    <td class="xl65" style="border-left: none; width: 311pt;" width="414">
      yuuuu
    </td>
  </tr>
  
  <tr style="height: 15.0pt;" height="20" valign="bottom">
    <td class="xl65" style="height: 15.0pt; border-top: none;" height="20">
      hhgff.1.2.3
    </td>
    
    <td class="xl65" style="border-top: none; border-left: none;">
      1.2.3
    </td>
  </tr>
  
  <tr style="height: 15.0pt;" height="20" valign="bottom">
    <td class="xl65" style="height: 15.0pt; border-top: none;" height="20">
      fgdfgf.fdgdfg.fgfd
    </td>
    
    <td class="xl65" style="border-top: none; border-left: none;">
      fdgdfg.fgfd
    </td>
  </tr>
  
  <tr style="height: 15.0pt;" height="20" valign="bottom">
    <td class="xl65" style="height: 15.0pt; border-top: none;" height="20">
      t.6364y
    </td>
    
    <td class="xl65" style="border-top: none; border-left: none;">
      6364y
    </td>
  </tr>
  
  <tr style="height: 15.0pt;" height="20" valign="bottom">
    <td class="xl65" style="height: 15.0pt; border-top: none;" height="20">
      A888999
    </td>
    
    <td class="xl65" style="border-top: none; border-left: none;">
      A888999
    </td>
  </tr>
</table>

Use this to find values between two values.  
**MID(A8,FIND(&#8220;(&#8220;,A8)+1,FIND(&#8220;)&#8221;,A8)-FIND(&#8220;(&#8220;,A8)-1)**

<table border="0" cellspacing="0" cellpadding="0" width="578">
  <colgroup> <col width="164"></col> <col width="414"></col> </colgroup> <tr height="20" valign="bottom">
    <td style="height: 15.0pt; width: 123pt;" width="164" height="20">
      <span style="color: #000000;">555 (999-0000)</span>
    </td>
    
    <td style="width: 311pt;" width="414">
      999-0000
    </td>
  </tr>
</table>

This one find text always to the right of a value (assumes within the last 5 chars) of a string.

<table border="0" cellspacing="0" cellpadding="0" width="781" height="86">
  <colgroup> <col style="mso-width-source: userset; mso-width-alt: 5997; width: 123pt;" width="164"></col> <col style="mso-width-source: userset; mso-width-alt: 15140; width: 311pt;" width="414"></col> </colgroup> <tr style="height: 15.0pt;" height="20" valign="bottom">
    <td style="height: 15.0pt; mso-ignore: colspan; width: 434pt;" colspan="2" width="578" height="20">
      <strong><span style="color: #000000;">IF(FIND(&#8220;.&#8221;,CONCATENATE(A13,&#8221;.&#8221;)) <= LEN(A13),RIGHT(A13,FIND(&#8220;.&#8221;,RIGHT(A13,5))+2),A13)</span></strong>
    </td>
  </tr>
  
  <tr style="height: 15.0pt;" height="20" valign="bottom">
    <td style="height: 15.0pt;" height="20">
      <span style="color: #000000;">filename.doc</span>
    </td>
    
    <td>
      .doc
    </td>
  </tr>
  
  <tr style="height: 15.0pt;" height="20" valign="bottom">
    <td style="height: 15.0pt;" height="20">
      <span style="color: #000000;">hfhg/fghfgh/hh</span>
    </td>
    
    <td>
      hfhg/fghfgh/hh
    </td>
  </tr>
</table>

<div class="zemanta-pixie">
  <img class="zemanta-pixie-img" src="http://img.zemanta.com/pixy.gif?x-id=2b8ebf75-4781-88ba-b542-4fb3fa5a7ab7" alt="" />
</div>