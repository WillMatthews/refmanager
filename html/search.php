<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<!-- Adapted from FEUDAL
      VERSION 3 -->

<html>
<head>
<style type="text/css">
body,td,th {
    font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif;
    text-align: center;
    font-size: small;
}
</style>
<title>AgriCoat Library Search</title>
<link href="style_std.css" rel="stylesheet" type="text/css">
<style type="text/css">
body,td,th {
    font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif;
    text-align: center;
    font-size: small;
}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
<FORM ACTION="search.php" method=get>
  <table width="100%" height="734" border="0" cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td><table width="100%" height="980" border="0" cellpadding="0" cellspacing="0">
        <tbody>
        <tr>
          <td width="60%"><table width="100%" height="734" border="0" cellpadding="0" cellspacing="0">
            <tbody>
              <tr>
                <td><table width="100%" height="980" border="0" cellpadding="0" cellspacing="0">
                  <tbody>
                    <tr>
                      <td width="20%" height="144">&nbsp;</td>
                      <td width="60%"><p class="s_font"><strong><em style="font-size: 64px">AgriCoat Library</em></strong></p>
                        <p class="s_font" style="font-size: 16px"><a href="search.php">Search</a> • <a href="add.php">Add Record</a> • <a href="errors.php">Errors</a></p></td>
                      <td width="20%">&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="235">&nbsp;</td>
                      <td><table width="575" height="227" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tbody>
                          <tr>
                            <td width ="70" height="57">&nbsp;</td>
                            <td width="435"><div style = "text-align:center"><span class="Style_1" style="font-size: medium"> Search AgriCoat Library</span></div></td>
                            <td width="70">&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="35">&nbsp;</td>
                            <td><input name="query" type="text" autofocus="autofocus" class="Style_1" placeholder="Insert Your Search Term (words separated by single spaces)" size="44" maxlength="35" value="<?php echo isset($_GET['query']) ? $_GET['query'] : '' ?>" ></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="34">&nbsp;</td>
                            <td><input type="submit" class="Style_1" value="Search"  ></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="0">&nbsp;</td>
                            <td style="text-align: center"><p><br />
                              Choose how data should be presented:</p>
                              <table width="225" align="center">
                                <tr>
                                  <td width="210" style="text-align: left"><label>
                                    <input name="order" type="radio" id="order_0" value="un"<?php if($_GET['order'] == "un" OR !$_GET['order']) { print ' checked="checked"'; } ?>>
                                    Unordered (fast)</label></td>
                                </tr>
                                <tr>
                                  <td style="text-align: left"><label>
                                    <input type="radio" name="order" value="or" id="order_1"<?php if($_GET['order'] == "or") { print ' checked="checked"'; } ?>>
                                    Ordered by Relevance (slow)</label></td>
                                </tr>
                              </table>
                              <p></p></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td style="text-align: center"><p>Something not working? Contact William or Charles</p></td>

                            <td>&nbsp;</td>
                          </tr>
                        </tbody>
                      </table></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="135">&nbsp;</td>
                      <td style="font-size: 16px"><p><span style="font-size: medium">
<?php

// indenting needs fixing...
function highlight($text, $words) {
    preg_match_all('~\w+~', $words, $m);
    if(!$m) {
      return $text;
    }
    $re='~\\b(' . implode('|', $m[0]) . ')\\b~i';
    return preg_replace($re, '<mark>$0</mark>', $text);
}

function addhttp($url) {
  if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
    $url = "http://" . $url;
  }
  return $url;
}

    // SQL VARS
    include 'dbconn.php';

    // Start Timer
    $time_start=microtime(true);

    if(!$con) {
        echo " ERROR. Could not connect to database.";
        echo "<br/>".mysqli_connect_errno() . ":" . mysqli_connect_error();
    } else {
    
        // gets _GET info
        $query=ltrim(rtrim($_GET['query']));
        $order=$_GET['order'];
  
        // $query max and min length - check this
        $max_length=30;
        $min_length=0;
    
        // run only if query exists (not on page load)
        if($query) {
            if(strlen($query) >= $min_length AND strlen($query) <= $max_length) { // query length to stop people breaking our page
                // General input sanitation
                $query=htmlspecialchars($query); 
                $order=htmlspecialchars($order); 
                $query=mysqli_real_escape_string($con,$query);
                $order=mysqli_real_escape_string($con,$order);

                // Heading Output
                echo "<b>Search Results:<br/></b>";

                /*
                // User Order Request data - manipulates SQL Search (DO NOT USE FOR NATURAL LANGAUGE)
                if($order == "kd"){
                    $ordercode = "`key` DESC";
                } elseif($order == "ka"){
                    $ordercode = "`key` ASC";
                } elseif($order == "dd"){
                        $ordercode = "`year` DESC";
                } elseif($order == "da"){
                        $ordercode = "`year` ASC";
                } else {
                    // Catch people fiddling and tell them to back down.
                    echo "<br/> <b> STOP TRYING TO BREAK OUR STUFF! </b> <br/>";
                    exit();
                }
                */

                // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                //  N A T U R A L   L A N G U A G E   S E A R C H
                // Check if $query is only digits - if it is then add to $sql_SQRY a search for the number column
                if(ctype_digit($query)) {

                    $sql_SQRY="SELECT library.`id`,
                               library.`key`,
                               library.`author`,
                               library.`year`,
                               library.`abstract`,
                               library.`keywords`,
                               library.`volume`,
                               library.`number`,
                               library.`pages`,
                               library.`url`,
                               library.`comments`,
                               library.`title`,
                               library.`haspdf` FROM `library` WHERE `key` LIKE ".$query.";";

                } else {
                  if($order=="un") {
                    $sql_SQRY="SELECT library.`id`,
                               library.`key`,
                               library.`author`,
                               library.`year`,
                               library.`abstract`,
                               library.`keywords`,
                               library.`volume`,
                               library.`number`,
                               library.`pages`,
                               library.`url`,
                               library.`comments`,
                               library.`title`,
                               library.`haspdf` FROM `library` WHERE MATCH (comments,abstract,keywords,title,author) AGAINST ('" .  $query . "' IN NATURAL LANGUAGE MODE);";

                  } elseif($order=="or") {
                      $querypls=str_replace(' ','+',$query);
                      $sql_SQRY = "SELECT *,
                                    MATCH (comments,abstract,keywords,title,author) AGAINST ('" . $query . "') AS relevance
                                FROM `library`
                                WHERE MATCH (comments,abstract,keywords,title,author) AGAINST ('" . $querypls . "' IN BOOLEAN MODE)
                                ORDER BY relevance DESC";
                            //HAVING relevance > 0.2
                  } else { 
                    echo "Unrecognized Order Code";
                    exit();
                  }



                }


                // Nautral Language Search with "relevance score" ordering..
                // under testing - not finalised yet
                // ===========================================================
                // $query = "'" . $query . "'";
                // $sql_SQRY = "SELECT *,
                //                 MATCH (comments,abstract,keywords,title,author) AGAINST ('" . $query . "' IN NATURAL LANGUAGE MODE) AS relevance,
                //                 MATCH (title) AGAINST ('" . $query . "' IN NATURAL LANGUAGE MODE) AS title_relevance
                //             FROM `library`
                //             WHERE MATCH (comments,abstract,keywords,title,author) AGAINST ('" . $query . "' IN NATURAL LANGUAGE MODE)
                //             ORDER BY title_relevance DESC, relevance DESC";
                //


                // Runs SQL Query
                $result=mysqli_query($con,$sql_SQRY);
                
                // Get number of rows, stop timer, calculte runtime & round.
                $rowcount=mysqli_num_rows($result);
                $time_stop=microtime(true);
                $time_exec=$time_stop-$time_start;
                $runtime_1=round($time_exec,3);

                // Just below the 'Search Results' heading - display search info
                echo $rowcount;
                if($rowcount == 1){
                    echo " hit for the search: ";
                } else {
                    echo " hits for the search: ";
                }
                echo "<i>'".$query."'</i>  in ".$runtime_1." seconds<br/><br/><br/>";

                // Displays error if we get no result.
                if(!$result) {
                    echo "ERROR!  NO RESULT RETURNED FROM TABLE<br/>";
                    echo mysqli_error($con);
                    echo "<br/>";
                }

                // Result processing
                if($rowcount > 0) {
                    // Output data of each row
                        while($row=mysqli_fetch_assoc($result)) {
                        // check BLOB for pdf presence:
                        if(!empty($row["haspdf"])) {
                            $imout="<a href='getpdf.php?record=". $row["id"] ."' target='_blank'><img src='static/pdf_icon.png' height='35'></a>";
                        } else {
                            //$imout = "<img src='static/nopdf_icon.png' height='42' width='42'>";
                            $imout="<a href='uploadpdf.php?record=". $row["id"] ."' target='_blank'><img src='static/nopdf_icon.png' height='35'></a>";
                        }
                        $editbtn="<a href='edit.php?record=".$row["id"]."' target='_blank'><img src='static/edit.png' height='20'></a>";

                        // Outputs the Key # (linked) for a single row.  
                        echo "<b><i>Key#: ".$row["key"]."</b></i>    " . $imout ."   " . $editbtn .  "<br/>" ;
                        // Outputs the Title and year for a single row.
                        echo "<b>" . highlight($row["title"],$query)."</b><br/>";
                        echo "<u><i>" . highlight($row["author"],$query)."   ".$row["year"] ."</i></u><br/><br/>";
                        // Outputs the record information.
                        if(!empty($row["url"])) {
                            echo '<a href = "'.addhttp($row["url"]).'" >'.$row["url"].'</a><br/>';
                        }
                        if(!empty($row["abstract"])) {
                          echo "<i>" . highlight(nl2br(rtrim(ltrim($row["abstract"]))),$query)."</i><br/>";
                        }
                        if(!empty($row["keywords"])) {
                            echo "<font color='green'>".highlight($row["keywords"],$query)."</font>";
                            echo "<br/>";
                        }
                        if(!empty($row["comments"])) {
                            echo "<font color='blue'>".highlight($row["comments"],$query)."</font>";
                            echo "<br/>";
                        }

                        echo "<br/><hr><br/>";
                    }
                } else {
                    echo "No Results";
                }

                // Close SQL connection
                mysqli_close($con);
            }
            // Catch when people put in query of bad length and show error message
            else { // If query length is less than minimum
                echo "<b>Your query was rejected due to bad size.</b><br />";
                echo "Minimum length is ".$min_length;
                echo "<br />Maximum length is ".$max_length;
            }
            // Displayed result when no search is done. (no $query from $_GET)
        } else {
          echo "No Search Yet";
        }
    }
?>
                      </span></p></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="110">&nbsp;</td>
                      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tbody>
                          <tr>
                            <td height="80" style="font-style: normal; font-family: 'Gill Sans', 'Gill Sans MT', 'Myriad Pro', 'DejaVu Sans Condensed', Helvetica, Arial, sans-serif; font-size: medium;"><p></p></td>
                          </tr>
                          <tr>
                            <td height="66"><p style="font-size: xx-small"><strong>Disclaimer:</strong> Results produced by AgriCoat Search are not representitive of the viewpoints of the creators, or even AgriCoat. In no event will we be liable for any loss or damage including without limitation, indirect or consequential loss or damage, or any loss or damage whatsoever arising from loss of data or profits arising out of, or in connection with, the use of this website. Every effort is made to keep the website up and running smoothly. However, we take no responsibility for, and will not be liable for, the website being temporarily unavailable due to technical issues beyond our control. Use at own risk.</p>
                              <p>© William &amp; Charles Matthews 2019</p></td>
                          </tr>
                        </tbody>
                      </table></td>
                      <td>&nbsp;</td>
                    </tr>
                  </tbody>
                </table></td>
              </tr>
            </tbody>
          </table>            <p class="s_font">&nbsp;</p></td>
        </tr>
        </tbody>
      </table></td>
    </tr>
  </tbody>
  </table>
</form>
</body>
</html>
