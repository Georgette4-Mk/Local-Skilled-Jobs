<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>post a job page</title>
    <script src="https://kit.fontawesome.com/f8816b6217.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="job listings.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>
<body>
    <div class="container">
    <div class="side-bar">
        <ul>
            <li>
                <i class="fa-solid fa-house"></i> <a href="#" class="activ">Dashboard</a>
            </li>
            <li>
                <i class="fa-regular fa-message"></i> <a href="Messages.php">Messages</a>
            </li>
            <li>
                <i class="fa-solid fa-building"></i><a href="#"> Profile</a>
            </li>
            
            <li>
                <i class="fa-regular fa-calendar-days"></i></i><a class="tab active-tab" onclick="opentab ('job')">job Listing</a>
            </li>
            
            <li>
                <i class="fa-regular fa-calendar-days"></i><a class="tab" onclick="opentab ('settings')">Settings</a>
            </li>
            <li>
                <i class="fa-regular fa-calendar-days"> </i><a href="#">Help Center</a>
            </li>
            <li>
            <h1>LJ</h1>
            </li>
        </ul>
    </div>
    <section>
    <div class="main" id="job">
    <div class="head">
        <i class="fa-regular fa-bell"></i>
        <h2><i class="fa-solid fa-plus"></i>Post a job</h2>
    </div>
    </div>
    <div class="social-media">
        <h1>Job Listing</h1>
        <p>Here is your jobs listing status from July 19-July 25</p>
        <div class="select">
       <input type="date">
        </div>
    </div>
    <div class="title">
       <h2>Job List</h2>
    </div>
    <main class="table">
        <section class="table-body">
                <table>
                <thead>
                    <tr>
                        <th><input type="checkbox" class="boxs" onchange="checkAll(this)"><pre class="full">Roles</pre></th>
                        <th class="score"><pre>Score</pre></th>
                        <th class="hire"><pre>status</pre></th>
                        <th class="date"><pre> Date posted</pre></th>
                        <th class="action"><pre>Due Date</pre></th>
                        <th class="action"><pre> Job Type</pre></th>
                        <th class="action"><pre>Applicants</pre></th>
                        <th class="action"><pre>Needs</pre></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                       <td><input type="checkbox" class="box">Electrician</td>
                        <td>00</td>
                        <td><p class="live"> live</p></td>
                        <td>20 May 2024</td>
                        <td>24 May 2024</td>
                        <td><p class="fulltime"> Fulltime</p></td>
                        <td>19</td>
                        <td>4/11</td>
                        <td><p class="dot">...</p></td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="box">Carpenter</td>
                         <td>00</td>
                         <td><p class="live">live</p></td>
                         <td>16 May 2024</td>
                         <td>20 May 2024</td>
                         <td><p class="fulltime"> Fulltime</p></td>
                         <td>1,234</td>
                         <td>0/20</td>
                         <td><p class="dot2">...</p></td>
                     </tr>
                     <tr>
                        <td><input type="checkbox" class="box">Cook</td>
                         <td>4.5</td>
                         <td><p class="live">live</p></td>
                         <td>15 May 2024</td>
                         <td>24 May 2024</td>
                         <td><p class="parttime"> Parttime</p></td>
                         <td>2,435</td>
                         <td>1/5</td>
                         <td><p class="dot3">...</p></td>
                     </tr>
                     <tr>
                        <td><input type="checkbox" class="box">Barber</td>
                         <td>3.75</td>
                         <td><p class="closed">closed</p></td>
                         <td>13 May 2024</td>
                         <td>24 May 2024</td>
                         <td><p class="parttime"> Parttime</p></td>
                         <td>6,234</td>
                         <td>10/10</td>
                         <td><p class="dot4">...</p></td>
                     </tr>
                     <tr>
                        <td><input type="checkbox" class="box">Cobbler</td>
                         <td>4.8</td>
                         <td><p class="closed">closed</p></td>
                         <td>12 May 2024</td>
                         <td>24 May 2024</td>
                         <td><p class="fulltime"> Fulltime</p></td>
                         <td>12</td>
                         <td>20/20</td>
                         <td><p class="dot5">...</p></td>
                     </tr>
                     <tr>
                        <td><input type="checkbox" class="box">Hair Dresser</td>
                         <td>4.6</td>
                         <td><p class="closed">closed</p></td>
                         <td>11 May 2024</td>
                         <td>24 July 2024</td>
                         <td><p class="fulltime"> Fulltime</p></td>
                         <td>14</td>
                         <td>10/10</td>
                         <td><p class="dot6">...</p></td>
                     </tr>   <tr>
                        <td><input type="checkbox" class="box">Cleaner</td>
                         <td>4.0</td>
                         <td><p class="closed">closed</p></td>
                         <td>12 May 2024</td>
                         <td>24 May 2024</td>
                         <td><p class="fulltime"> Fulltime</p></td>
                         <td>12</td>
                         <td>20/20</td>
                         <td><p class="dot7">...</p></td>
                     </tr>
                    
                </tbody>
            </table>
        </section>
    </main>
    <div class="foot">
        <div class="simi-footer">
            <h4>view</h4>
            <p>10</p>
            <h3><pre>Applicants per page</pre></h3>
        </div>
        <div class="number">
        <span>1</span> <p>2</p>
        <h2><</h2><h3>></h3> 
        </div>
    </div>
    </section>
    </div>
    <script>
        var checkboxes = document.querySelectorAll("input[type = 'checkbox']");
       function checkAll(mycheckbox){
        if(mycheckbox.checked == true){
            checkboxes.forEach(function(checkbox){
                checkbox.checked = true
            });
        }
        else{
            checkboxes.forEach(function(checkbox){
                checkbox.checked = false;
            }
        );
        }
       }
    </script>
    <script>
        var tablinks = document.getElementsByClassName("tab-links");
        var tabcontents = document.getElementsByClassName("tab-contents");

        function opentab(tabname){
            for(tablink of tablinks){
                tablink.classList.remove("active-link");
            }
            for(tabcontent of tabcontents){
                tabcontent.classList.remove("active-tab");
            }
            event.currentTarget.classList.add("active-link");
            document.getElementById(tabname).classList.add("active-tab");
        }
        </script>
</body>
</html>