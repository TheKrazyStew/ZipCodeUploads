<!doctype html>
<html>
  <head>
    <title>Output</title>
  </head>
  <body>
  <?php 
  	echo "Fee Fee Baptist Church<br>Forerunner ZIP Code Analysis<br>" # Top of the page
  	. date("m,d,Y") 
  	. "<br>Vol. " . $_POST["vol"] . " No. " . $_POST["edition"] . "<br>"; # Which edition of the Forerunner is this?
	
	#Initializing variables
	  
    $target = "target_file.txt"; # What the file will be renamed
	  
    $zip_bank = array( # Zip Bank #1 - Used in Check/Count #1
      63017,
      63031,
      63033,
      63042,
      63043,
      63044,
      63074,
      63114,
      63134,
      63146,
      63301,
      63303,
      63304,
      63366,
      63368,
      63376,
      63385,
	  63034,
	  63141
    );
    $zip_bank_2 = array( # Zip Bank #2 Used in Check/Count #2
      630,
      631,
      633
    );
    $zip_bank_3 = array( # Zip Bank #3 - Used in Check/Count #3
      620,
      622,
      623,
      624,
      625,
      626,
      627,
      628,
      629,
      630,
      631,
      633,
      634,
      635,
      636,
      637,
      638,
      639,
      640,
      641,
      644,
      645,
      646,
      647,
      648,
      649,
      650,
      651,
      652,
      653,
      654,
      655,
      656,
      657,
      658,
      660,
      661,
      662,
      664,
      665,
      666,
      667,
      668
    );

    $group_total_1 = 0; # Initializing the total counts for each group
    $group_total_2 = 0;
    $group_total_3 = 0;
    $group_total_4 = 0;

    echo "FORMAT<br>Zip Code: #####\tLabels: #<br><br>";

    if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target)){ # Upload the file. Only proceed if the file is successfully uploaded.
      $lines = file($target);
      foreach($lines as $line) { # Reading each line as its own zip code
        $line = trim($line); # Removing any accidental whitespace that may be present
        $zip5 = substr($line,0,5); # 5-digit ZIP Code, used for Check 1. Some ZIPs are 9 digits, so they are shortened here.
        $zip3 = substr($line,0,3); # 3-digit ZIP Code, used for Check 2/3. These checks only require the first three digits, as they are less specific than check 1.
        if(in_array($zip5,$zip_bank)){ # Check 1 - Is the five-digit code in the first bank?
          $group_total_1 ++; # Keeping track of the amount of ZIPs in group 1
          if(!isset($$zip5)) { # Count 1 - keeps track of every individual ZIP Code in the group using variable variables
          	$$zip5 = 1;
          } else {
          	$$zip5 += 1;
          }
        } elseif(in_array($zip3,$zip_bank_2)) { # Check 2 - Only activates upon failure of Check 1. Is the three-digit code in the second bank?
          $group_total_2 ++; # Keep track of the amount of ZIPs in group 2
          if(!isset($$zip3)) { # Count 2
          $$zip3 = 1;
          } else {
          $$zip3 += 1;
        }
        } elseif(in_array($zip3,$zip_bank_3)) { # Check 3 - Only activates upon failure of Check 1/2. Is the three-digit code in the national bank?
          $group_total_3 ++; # Keep track of the amount of ZIPs in group 3
          if(!isset($$zip3)) { # Count 3
            $$zip3 = 1;
          } else {
            $$zip3 += 1;
        }
        } else { # If all checks fail, then this ZIP belongs to the miscellaneous group. This does not get its own variable variable counts.
          $group_total_4 ++; # Keep track of the amount of ZIPs in group 4
        } # if
        
      } # foreach

      echo "GROUP 1:<br>";  #Printing the results on-screen
      foreach($zip_bank as $zip) { # Display each count for the Group #1 ZIPs
          echo "5-Digit Zip Code: " . $zip . "Labels: " . $$zip . "<br>";
      } # foreach
      echo "GROUP 1 TOTAL: " . $group_total_1 . "<br>";
		
      echo "<br>GROUP 2:<br>";
      foreach($zip_bank_2 as $zip) { # Display each count for the Group #2 ZIPs
        echo "3-Digit Zip Code: " . $zip . "\tLabels: " . $$zip . "<br>";
      } # foreach
      echo "GROUP 2 TOTAL: " . $group_total_2 . "<br>";
      
      echo "<br>GROUP 3:<br>";
      $st_louis_count = 0; # Group #3 is to be divided into two categories: St. Louis...
      $ks_city_count = 0; # ...and Kansas City
      foreach($zip_bank_3 as $zip) {
        if($zip < 640) { # ZIP codes less than 640 are in the St Louis area
          $st_louis_count += $$zip;
        } else { # The rest of the ZIP codes are in the Kansas City area
          $ks_city_count+= $$zip;
        }
      } # foreach
		
      echo "ADC ST LOUIS MO 630: " . $st_louis_count . "<br>"; # Display STL Results
      echo "ADC KANSAS CITY MO 64240: " . $ks_city_count . "<br>GROUP 3 TOTAL: " . $group_total_3 . "<br>"; # Display KSC and Group 3 total results
		
      echo
      "<br>GROUP 4 - Mixed ADC TOTAL: " . $group_total_4; # Group 4 has no special counts, just the total
		
		echo "<br><br>TOTAL LABELS: " . ($group_total_1 + $group_total_2 + $group_total_3 + $group_total_4); # Total amount of labels in the entire file, calculated by adding the four group totals together
   } else { # If this is triggered, the file did not upload properly.
		echo "Error: File did not upload. Please try again.";
	}# if uploaded
  ?> 
  </body>
</html>