<?php
	$servername = "localhost";
	$username = "root";
	$password = "123456";
	$dbname = "team_project";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>World Happiness</title>
    <style>
        table, td, th {
            border: 1px solid black;
            font-family: courier;
            text-align: center;

        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th {
            height: 20px;
        }

        td{
            height: 30px;
        }

        label, option {
            font-family: courier;
        }
    </style>
</head>
<body>
    <h2>Filter</h2>   
	<form action="try.php" method="get">
        <label>Region:</label>
		<select name="region">
            <option value="NORTHERN AMERICA">Northern America</option> <!--NORTHERN AMERICA-->
            <option value="LATIN AMER. & CARIB">Latin America & the Caribbean</option> <!--LATIN AMER. & CARIB-->	    
            <option value="WESTERN EUROPE"> Western Europe </option> <!--WESTERN EUROPE-->
		    <option value="EASTERN EUROPE"> Eastern Europe </option> <!--EASTERN EUROPE-->
            <option value="BALTICS"> Baltics </option> <!--BALTICS-->
            <option value="ASIA (EX. NEAR EAST)"> Asia </option> <!--ASIA (EX. NEAR EAST)-->
            <option value="NEAR EAST">Near East</option> <!--NEAR EAST-->
		    <option value="OCEANIA">Oceania</option> <!--OCEANIA-->
            <option value="NORTHERN AFRICA">Northern Africa</option> <!--NORTHERN AFRICA-->
            <option value="SUB-SAHARAN AFRICA">Sub-Saharan Africa</option> <!--SUB-SAHARAN AFRICA-->
            <option value="C.W. OF IND. STATES">Others</option> <!--C.W. OF IND. STATES-->
            <option value="No" selected>I don't care</option>
		</select><br>

		<label>Income:</label>
		<select name="income">
		    <option value="0~10000"><10000</option>
		    <option value="10000~30000">10000~30000</option>
            <option value="30000~50000">30000~50000</option>
            <option value="50000~70000">50000~70000</option>
            <option value="70000~90000">70000~90000</option>
            <option value="90000~110000">90000~110000</option>
            <option value="110000~999999999">>110000</option>
            <option value="No" selected>I don't care</option>
		</select><br>
        

        <label>Life Expectancy:</label>
		<select name="life_expectancy">
		    <option value="30~40">30~40</option>
		    <option value="40~50">40~50</option>
            <option value="50~60">50~60</option>
            <option value="60~70">60~70</option>
            <option value="70~80">70~80</option>
            <option value="80~90">80~90</option>
            <option value="No" selected>I don't care</option>
		</select><br>

        <label>Net Migrants:</label>
		<select name="net_migrants">
		    <option value="-700000~-350000">-700000~-350000</option>
		    <option value="-350000~0">-350000~0</option>
		    <option value="0~300000">0~300000</option>
		    <option value="300000~600000">300000~600000</option>
            <option value="600000~900000">600000~900000</option>
            <option value="No" selected>I don't care</option>
		</select><br>

        <label>Population:</label>
		<select name="population">
		    <option value="0~50000000"><50000000</option>
		    <option value="50000000~60000000">50000000~60000000</option>
		    <option value="60000000~70000000">60000000~70000000</option>
            <option value="70000000~80000000">70000000~80000000</option>
            <option value="80000000~90000000">80000000~90000000</option>
            <option value="90000000~100000000">90000000~100000000</option>
            <option value="100000000~9999999999999">>100000000</option>
            <option value="No" selected>I don't care</option>
		</select><br>

        <label>Schooling Years:</label>
		<select name="schooling_years">
		    <option value="0~5">0~5</option>
		    <option value="5~10">5~10</option>
		    <option value="10~15">10~15</option>
		    <option value="15~20">15~20</option>
            <option value="No" selected>I don't care</option>            
		</select><br>
        <input type="submit" name = "submit-search" value ="submit" font-family: courier><br>   
	</form>

	<h2>Results</h2>
	<div>
        
		<?php

			// Query database
			$sql = "SELECT country FROM countries";

			// If the search button is clicked
			if (isset($_GET['submit-search'])) {
                $flag = 1;
                $region = mysqli_real_escape_string($conn, $_GET['region']);
                if ($region == "No") {
                    $flag = 0;
                }

                
                $income = mysqli_real_escape_string($conn, $_GET['income']);
                if ($income == "No") {
                    $income_low = 0;
                    $income_high = 999999999;
                }
                else {
                    $Newincome = preg_split("/~/", $income);
                    $income_low = (int)$Newincome[0];
                    $income_high = (int)$Newincome[1];
                }
                
                $life_expectancy = mysqli_real_escape_string($conn, $_GET['life_expectancy']);
                if ($life_expectancy == "No") {
                    $life_expectancy_low = 30;
                    $life_expectancy_high = 90;
                }
                else {
                    $Newlife_expectancy = preg_split("/~/", $life_expectancy);
                    $life_expectancy_low = (int)$Newlife_expectancy[0];
                    $life_expectancy_high = (int)$Newlife_expectancy[1];
                }

                $net_migrants = mysqli_real_escape_string($conn, $_GET['net_migrants']);
                if ($net_migrants == "No") {
                    $net_migrants_low = -700000;
                    $net_migrants_high = 900000;
                }
                else {
                    $Newnet_migrants = preg_split("/~/", $net_migrants);
                    $net_migrants_low = (int)$Newnet_migrants[0];
                    $net_migrants_high = (int)$Newnet_migrants[1];
                }
               
                $population = mysqli_real_escape_string($conn, $_GET['population']);
                if ($population == "No") {
                    $population_low = 0;
                    $population_high = 100000000;
                }
                else {
                    $Newpopulation = preg_split("/~/", $population);
                    $population_low = (int)$Newpopulation[0];
                    $population_high = (int)$Newpopulation[1];
                }
               
                $schooling_years = mysqli_real_escape_string($conn, $_GET['schooling_years']);
                if ($schooling_years == "No") {
                    $schooling_years_low = 0;
                    $schooling_years_high = 20;
                }
                else {
                    $Newschooling_years = preg_split("/~/", $schooling_years);
                    $schooling_years_low = (int)$Newschooling_years[0];
                    $schooling_years_high = (int)$Newschooling_years[1];
                }
               
                //echo "I love you" . "<br>";

				
                // $sql = "SELECT DISTINCT countries.country, countries.Region, countriesdata.Income, countriesdata.life_expec, population_by_country.Migrants, population_by_country.Population
                //     FROM countries, countriesdata , data2015 , life_expectancy_data , population_by_country 
                //     WHERE 
                //     (countriesdata.Income BETWEEN $income_low AND $income_high) AND 
                //     (countriesdata.life_expec between $life_expectancy_low AND $life_expectancy_high) AND 
                //     (population_by_country.Migrants between $net_migrants_low AND $net_migrants_high) AND
                //     (population_by_country.Population between $population_low AND $population_high) AND
                //     (life_expectancy_data.Schooling between $schooling_years_low AND $schooling_years_high) AND
                //     (countries.country = countriesdata.country) AND
                //     (countries.country = data2015.country) AND
                //     (countries.country = life_expectancy_data.country) AND
                //     (countries.country = population_by_country.country) AND
                //     (countries.country = countriesdata.country)";

                $sql = "SELECT DISTINCT countries.country, countries.Region, countriesdata.Income, countriesdata.life_expec, population_by_country.Migrants, population_by_country.Population, life_expectancy_temp.Schooling_Year, data2015.HappinessRank, data2015.HappinessScore, data2015.StandardError, data2015.Economy, data2015.Family, data2015.Health, data2015.Freedom, data2015.Trust, data2015.Generosity, data2015.DystopiaResidual
                        FROM countries, countriesdata , data2015 , population_by_country,
                        (SELECT country, AVG(Schooling) AS Schooling_Year FROM life_expectancy_data GROUP BY country) AS life_expectancy_temp
                        WHERE 
                        (countriesdata.Income BETWEEN $income_low AND $income_high) AND 
                        (countriesdata.life_expec BETWEEN $life_expectancy_low AND $life_expectancy_high) AND 
                        (population_by_country.Migrants BETWEEN $net_migrants_low AND $net_migrants_high) AND
                        (population_by_country.Population BETWEEN $population_low AND $population_high) AND
                        (life_expectancy_temp.Schooling_year BETWEEN $schooling_years_low AND $schooling_years_high) AND
                        (countries.country = countriesdata.country) AND
                        (countries.country = data2015.country) AND
                        (countries.country = life_expectancy_temp.country) AND
                        (countries.country = population_by_country.country) AND
                        (countries.country = countriesdata.country)";
                if ($flag) {
                    $sql = $sql . "AND (countries.Region = '$region')";
                }
                $sql = $sql . "ORDER BY data2015.HappinessRank";
                //echo $sql;
			}
			
			$result = $conn->query($sql);
            //echo "!!!";
			if ($result->num_rows > 0) {
		    	// output data of each row
                echo "<table>";
                echo "<tr>";
                echo "<th>Happiness<br>Rank</th>";
                echo "<th>Country</th>";
                echo "<th>Region</th>";
                echo "<th>Income</th>";
                echo "<th>Life<br>Expectancy</th>";
                echo "<th>Migrants</th>";
                echo "<th>Population</th>";
                echo "<th>Schooling</th>";
                echo "<th>Happiness<br>Score</th>";
                echo "<th>Standard<br>Error</th>";
                echo "<th>Economy</th>";
                echo "<th>Health</th>";
                echo "<th>Freedom</th>";
                echo "<th>Trust</th>";
                echo "<th>Generosity</th>";
                echo "<th>Dystopia<br>Residual</th>";
                echo "</tr>";
			    while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["HappinessRank"] . "</td>";
                    echo "<td>" . $row["country"] . "</td>";
                    echo "<td>" . $row["Region"] . "</td>";
                    echo "<td>" . $row["Income"] . "</td>";
                    echo "<td>" . $row["life_expec"] . "</td>";
                    echo "<td>" . $row["Migrants"] . "</td>";
                    echo "<td>" . $row["Population"] . "</td>";
                    echo "<td>" . number_format((float)$row["Schooling_Year"], 2, '.', '') . "</td>";
                    echo "<td>" . number_format((float)$row["HappinessScore"], 2, '.', '') . "</td>";
                    echo "<td>" . number_format((float)$row["StandardError"], 2, '.', '') . "</td>";
                    echo "<td>" . number_format((float)$row["Economy"], 2, '.', '') . "</td>";
                    echo "<td>" . number_format((float)$row["Health"], 2, '.', '') . "</td>";
                    echo "<td>" . number_format((float)$row["Freedom"], 2, '.', '') . "</td>";
                    echo "<td>" . number_format((float)$row["Trust"], 2, '.', '') . "</td>";
                    echo "<td>" . number_format((float)$row["Generosity"], 2, '.', '') . "</td>";
                    echo "<td>" . number_format((float)$row["DystopiaResidual"], 2, '.', '') . "</td>";
                    // HappinessScore Standard Error  Economy (GDP per Capita)    Family  Health (Life Expectancy)    Freedom Trust (Government Corruption)   Generosity  DystopiaResidual
			        
                    echo "</tr>";
			    }
                echo "</table>";
			} else {
			    echo "0 results";
			}
		?>
	</div>
	<h2>Comment</h2>
	<div>
		<form name = "board" action = "try.php" method = "post">
			<p>暱稱</p>
			<p><input type = "text" name = "name"></p>
			<p>主題</p>
			<p><input type = "text" name = "subject"></p>
			<p>留言</p>
			<p><textarea style = "width:550px; height:100px;" name = "content"></textarea></p>
			<p><input type = "submit" name = "submit" value = "提交">
		<div class = "note full-height">
			<?php
				if(isset($_POST['submit']))
				{
					$name = $_POST['name'];
					$subject = $_POST['subject'];
					$content = $_POST['content'];
					$sql = "INSERT guestbook(name, subject, content, time) VALUES ('$name', '$subject', '$content', now())";
					if(!mysqli_query($conn, $sql))
					{
						die(mysqli_error());
					}
					else
					{
						echo"<script>window.location.href='try.php';</script>";
					}
				}
				$sql = "select * from guestbook order by time desc limit 5";
				$sql_ = "select * from guestbook";
				$result = mysqli_query($conn, $sql);
				$result_ = mysqli_query($conn, $sql_);
				while($row = mysqli_fetch_assoc($result))
				{
					echo "<br>暱稱：" . $row['name'];
					echo "<br>主題：" . $row['subject'];
					echo "<br>留言：" . nl2br($row['content']) . "<br>";
					echo "時間：" . $row['time'] . "<br>";
					echo "<hr>";
				}
				echo "<br>";
				echo '<div class="bottom left position-abs content">';
				echo "一共有" . mysqli_num_rows($result_) . "則留言";
				echo "<br>目前顯示最新5則留言";
			?>
			</div>
		</div>
	</div>
</body>
</html>
