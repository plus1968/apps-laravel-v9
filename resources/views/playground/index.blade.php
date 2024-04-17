@include('playground.templates.header')

<!-- Your page content goes here -->

<style>
    body {
        background: #333;
    }

    .premierle {
        background: #fff;
        width: 100%;
        height: 100%;
        border-radius: 23px;
    }

    .fillter {
        /* display: flex; */
        margin-bottom: 4.1rem;
        /* padding: 0; */
        border: 1px solid #f5f2f5;
        border-radius: 0.3rem;
        align-items: center;
    }

    .fillter div {
        border-right: 1px solid #f5f2f5;
    }

    .fillter select {
        border: 1px solid #f5f2f5;
        padding: 2px;
        font-size: 16pt;
        width: 100%;
        height: 40px;
        background: none;
        border-radius: 23px;
    }

    .prl {
        width: 100%;
        text-align: left;
        border-collapse: collapse;
        color: #37003c;
        height: 100%;
    }

    .prl td {
        /* width: 100%; */
        text-align: left;
        color: #37003c;
        padding: 5px;
        border-bottom: 1px solid #f5f2f5;
    }

    .prl th {
        padding: 5px;
        font-size: 12pt;
        text-align: left;
    }

    .prl thead tr {
        background-color: #fbfafa;
        border-bottom: 0.1rem solid #ebe5eb;
        font-size: 1.2rem;
        color: #87668a;
        font-weight: 400;
        line-height: 1.8rem;
    }

    .tablepr {
        border: 1px solid #f5f2f5;
        border-radius: 0.3rem;
        align-items: center;
        padding: 5px;
    }

    .logosteam {
        border-radius: 50%;
        padding: 2px;
        border: 1px solid #87668a;

    }
</style>



<div class='row'>
    <div class="premierle col-lg-12 p-3">
        <div class="fillter row m-1 p-3">
            <div class="col-lg-4 LogoLeague">

            </div>

            <div class="col-lg-4">
                <?php
                $year = date('Y');
                $lasttenyear = $year - 10;
                
                ?>
                <select onchange='handleDataStandings();' id='season'>
                    <?php
                    for ($year; $year > $lasttenyear; $year--) {
                        $cur = $year-1;
                        $next = $year;
                        // เพิ่มเงื่อนไขถ้าหลังเดือน 8 ให้ใช้ปีถัดไป
                        if (date('m') >= 8) {
                            $cur = $year;
                            $next = $year + 1;
                        }

                        echo "<option value='$cur'>$cur-$next</option>";
                    }
                    
                    ?>
                </select>
            </div>
            <div class="col-lg-4">
                <select onchange='handleDataStandings();' id='league'>
                    <option value='eng.1'>Premier League</option>
                    <option value='esp.1'>Spanish LALIGA</option>
                    <option value='ger.1'>German Bundesliga</option>
                    <option value='ita.1'>Italian Serie A</option>
                    <option value='fra.1'>French Ligue 1</option>
                </select>
            </div>
        </div>
        <div class="tablepr col-lg-12 table-responsive">
            <table class='prl'>
                <thead>
                    <tr>
                        <th style='text-align:center;'width='20px'>Position</th>
                        <th width='250px' style='text-align:center;'>Club</th>
                        <th style='text-align:center;'>Played
        </div>
        </th>
        <th style='text-align:center;'>Won</th>
        <th style='text-align:center;'>Drawn</th>
        <th style='text-align:center;'>Lost</th>
        <th style='text-align:center;'><abbr title="Goals For">GF</abbr></th>
        <th style='text-align:center;'><abbr title="Goals Against">GA</abbr></th>
        <th style='text-align:center;'><abbr title="Goal Difference">GD</abbr></th>
        <th style='text-align:center;'> Points </th>
        </tr>
        </thead>
        <tbody class='showcontents'>

        </tbody>
        </table>
    </div>
</div>

</div>

@include('playground.templates.footer')


<script>
    $(document).ready(function() {

        handleDataStandings()

    });


    function handleDataStandings() {
        let season = $('#season').val();
        let league = $('#league').val();
        Loading('.showcontents');
        showlogosleague(league);

        fetchDataStandings(league, season)
            .then(result => {
                // console.log(result);
                // Handle the result here
                resultDataStandings(result)
            })
            .catch(error => {
                console.error(error);
                // Handle errors here
            });
    }

    function showlogosleague(league) {
        if (league === 'eng.1') {
            src =
                'https://upload.wikimedia.org/wikipedia/en/thumb/f/f2/Premier_League_Logo.svg/420px-Premier_League_Logo.svg.png';
        } else if (league === 'esp.1') {
            src =
                'https://upload.wikimedia.org/wikipedia/commons/thumb/5/54/LaLiga_EA_Sports_2023_Vertical_Logo.svg/330px-LaLiga_EA_Sports_2023_Vertical_Logo.svg.png';
        } else if (league === 'ger.1') {
            src =
                'https://upload.wikimedia.org/wikipedia/en/thumb/d/df/Bundesliga_logo_%282017%29.svg/255px-Bundesliga_logo_%282017%29.svg.png';
        } else if (league === 'ita.1') {
            src =
                'https://upload.wikimedia.org/wikipedia/commons/thumb/e/e9/Serie_A_logo_2022.svg/203px-Serie_A_logo_2022.svg.png';
        } else if (league === 'fra.1') {
            src =
                'https://upload.wikimedia.org/wikipedia/en/thumb/c/cd/Ligue_1_Uber_Eats_logo.svg/210px-Ligue_1_Uber_Eats_logo.svg.png';
        }
        $('.LogoLeague').html("<img width='150px' src='" + src + "'/>");
    }

    function fetchDataStandings(league, season) {
        return new Promise((resolve, reject) => {
            let url = 'https://site.web.api.espn.com/apis/v2/sports/soccer/' + league +
                '/standings?region=us&lang=en&contentorigin=espn&season=' + season + '&sort=rank%3Aasc';
            $.ajax({
                type: "get",
                url: url,
                // data: "data", // You might not need this line
                // dataType: "dataType", // You might not need this line
                success: function(response) {
                    resolve(response);
                },
                error: function(xhr, status, error) {
                    reject(error);
                }
            });
        });
    }

    function resultDataStandings(result) {
        let tables = result.children[0].standings.entries;
        let nametables = result.children[0].name;
        let allseason = result.seasons;
        let namecontent = '.showcontents';
        // console.log(tables);
        // console.log(nametables);
        if (tables === [] || tables === null) {
            nodata(namecontent);
        } else {
            let showcontents = null;

            $.each(tables, function(key, value) {
                no = parseInt(key + 1);
                teamname = value.team.name;
                logos = value.team.logos[0].href;
                background = value.note && value.note.color ? value.note.color : '';
                GP = value.stats[0].displayValue;
                LOSE = value.stats[1].displayValue;
                DRAW = value.stats[6].displayValue;
                WIN = value.stats[7].displayValue;
                GF = value.stats[5].displayValue;
                GA = value.stats[4].displayValue;
                GD = value.stats[2].displayValue;
                POINTS = value.stats[3].displayValue;
                // FORM = value.stats[3].displayValue;
                // console.log(background);

                showcontents += "<tr style='background:" + background + ";'>";
                showcontents += "<td style='text-align:center;'>" + no + "</td>"
                showcontents += "<td><img class='logosteam' src='" + logos + "' width='20px'> " + teamname +
                    "</td>"
                showcontents += "<td style='text-align:center;'>" + GP + "</td>"
                showcontents += "<td style='text-align:center;'>" + WIN + "</td>"
                showcontents += "<td style='text-align:center;'>" + DRAW + "</td>"
                showcontents += "<td style='text-align:center;'>" + LOSE + "</td>"
                showcontents += "<td style='text-align:center;'>" + GF + "</td>"
                showcontents += "<td style='text-align:center;'>" + GA + "</td>"
                showcontents += "<td style='text-align:center;'>" + GD + "</td>"
                showcontents += "<td style='text-align:center;font-weight:500;'>" + POINTS + "</td>"
                // showcontents += "<td style='text-align:center;'>"+ALLFORM+"</td>"

                showcontents += "</tr>";
            })
            console.log(tables);
            $(namecontent).html(showcontents);

        }
    }

    function Loading(etities) {
        $(etities).html("<tr><td colspan='13' >Loading...</td></tr>");
    }

    function nodata(etities) {
        $(etities).html("<tr><td colspan='13' >no data...</td></tr>");

    }
</script>
