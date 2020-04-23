# NEUB_RPS
This web application is developed for the result processing system of North East University Bangladesh.

<h2>Student Panel (General User)</h2>
<ul>
    <li>This panel will directly open by typing the url link.</li>
    <li>In header section a title  (click redirect to the same site) with a logo (click redirect to the official NEUB site) will appear.</li>
    <li>In display section there will be a welcome video (muted) with a caption (optional). In alternate there will be a image.</li>
    <li>In contact section university information with google map and a contact us form will appear.</li>
    <li>In footer section copyright and year will appear (onclick redirect to the official NEUB site).</li>
    <li>Student can search their result by using their Student ID (12 Digits) and Date of Birth (MM-DD-YYYY). Each search will be tracked by ip address and geo location (only admin can check it). A single search history will removed when it crosses the number 3000 in search list.</li>
    <li>Student can subscribe notification by clicking the text and will get email for result or any other change in his/her profile.</li>
    <li>Student will get all of his/her basic information that used in transcript.</li>
    <li>Student will get all of his/her result including drop course (according to the syllabus) and waived course.</li>
    <li>Incomplete result for any course will count as a fail in the transcript. Remarks will show in the result section but not in the transcript. Withdraw course information is not available in this portal.</li>
    <li>Student can print an online transcript which will be tracked by a reference no with ip address and geo location (only admin can check it). A single transcript print history will removed when it crosses the number 50000 in print list. <b>Note: </b>For a single query, only a single transcript is printable, for more print request query session will be destroyed.</li>
    <li>Student information add or edit right is available only for controller of examination.</li>
    <li>In case of unavailability of photo in student profile a demo profile image will show based on student gender.</li>
    <li>In contact us form general user can make a query which will directly send to the controller of examination email.</li>
    <li>If a student status changed to inactive then he/she can not access his/her result.</li>
    <li>If a course result status changed to inactive then it will not available in both result window and transcript.</li>
    <li>In every 5 seconds an automatice network connection check will be done.</li>
</ul>
    
<h2>Faculty Panel</h2>
<ul>
    <li>This panel will open by typing '/faculty' after the URL link.</li>
    <li>In header section a title  (click redirect to the same site) with a logo (click redirect to the official NEUB site) will appear.</li>
    <li>In the body section, there will be a login form with email, password and captcha fields. By filling these fields, faculty will get the access of faculty panel.</li>
    <li>By checking to Remember Me, faculty can save his/her password for 30 days (Except cache and cookie cleaning), on the other hand, for clearing credentials to check out the Remember Me. Credentials will remember after a successful login.</li>
    <li>By clicking Forget My Password, a form will appear with email and captcha. By filling this form, the faculty will receive a password reset link (one time useable) in his/her email. Faculty can reset his/her password by using the reset link.</li>
    <li>If faculty failed to reset his/her password, then it can be solved by the Controller of Examination admin (admin has the right to send the reset link in the faculty email but can not access the reset link). Password is highly secured (multiple custom encryption algorithm used), no one has the access to view the password, not even the admin.</li>
    <li>In footer section copyright and year will appear (click redirect to the official NEUB site).</li>
    <li>Faculty can log in if his/her ID and department are active. After a successful login, a two-factor authentication form will appear (if enable from faculty profile) here faculty has to insert an OTP that he/she received in his/her email. For successful OTP insertion with captcha, faculty will gain all the access. For three-time, wrong submission faculty id will be inactive (faculty will lose his/her access, only admin has the right to activate the account again).</li>
    <li>In faculty panel, the left side will contain basic information with four menu buttons: Dashboard, Search Result, Edit Profile, and Sign Out. And right side will show the page details for a menu button. At top of the right side, the menu title will appear. By default, the dashboard menu page will appear on the right side.</li>
    <li>In the dashboard, first there will be a view of the number of total students (including alumni and current students), total graduated students (completed any program successfully), top cgpa (maximum cgpa among all the graduate students considering all the programs), total dropouts students (For any student 2 or more semester drops considering current semester will count the student as a dropout in the list). Second, there will be a student statistics chart where faculty can see new students, graduate students and dropout students for semesters, faculty can select semesters from drop-down options on the top right of the chart. Dropdown options by default, select the last 5 semesters considering the last available semester data from the database. Third, there will be a CGPA statistics, line graph that will show semester top CGPA and semester graduates top CGPA in semesters, again faculty can select semesters from the drop-down option on the top right of the line graph. Last, there will be a table of recent results where faculty can see results in descending order from the database. Basically, 5 last results will show in the table but clicking show more faculty can see more 5 results and so on. <b>Note: </b>Only active data will show in the faculty panel. All type of inactive data will be hidden from the faculty panel.</li>
    <li>In the top right of the page, a program choose option is available where faculty can select any program or all program in his department to change the data. </li>
    <li>In search results, faculty can check student wise results or course wise results with search and sort option. For student wise results, faculty can check student basic info with semester wise results, fail courses, pass courses, drop courses (based on the syllabus), and waived courses. Each student wise result check will be tracked by IP address and geo-location (only admin can check it). Also, faculty can print an online transcript which will be tracked by a reference no with IP address and geo-location (only admin can check it). A single transcript print history will be removed when it crosses the number 50000 in the print list. On the other hand, in course wise result faculty can filter the data based on semesters and grades. By clicking view, faculty will get student basic info with course info, result info, and course instructor info. </li>
    <li>In edit profile faculty can edit his cell no, two-factor status, profile picture, and password.</li>
    <li>By clicking sign out session will be destroyed and faculty will sign out from the access.</li>
    <li>In every 8 seconds, an automatic network connection and session check will be done. Admin has the right to destroy any faculty member session.</li>
</ul>


