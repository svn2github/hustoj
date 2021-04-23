<?php
	//oj-header.php
	$MSG_FAQ="چۈشەنچە & سوئال";
	$MSG_BBS="تور بەت";
	$MSG_HOME="باش بەت";
	$MSG_PROBLEMS="مەسىلىلەر";
	$MSG_STATUS="ھالەت";
	$MSG_RANKLIST="دەرىجە";
	$MSG_CONTEST="مۇسابىقە";
	$MSG_RECENT_CONTEST="يېقىنقى";
	$MSG_LOGOUT="چىقىش";
	$MSG_LOGIN="كىرىش";
	$MSG_LOST_PASSWORD="مەخپى نۇمۇر يۈتتى";
	$MSG_REGISTER="رويخەتكە ئىلىش";
	$MSG_ADMIN="باشقۇرغۇچى";
	$MSG_SYSTEM="System";
	$MSG_STANDING="مەرتىۋە";
	$MSG_STATISTICS="سىتاتىستىكا";
	$MSG_USERINFO="ئابونىت ئۇچۇرى";
	$MSG_MAIL="ئېلخەت";

	//status.php
	$MSG_Pending="كۈتۈۋاتىدۇ...";
	$MSG_Pending_Rejudging="قايتا تەكشۈرۈشنى كۈتۈۋاتىدۇ...";
	$MSG_Compiling="تەرجىمىلىنىۋاتىدۇ...";
	$MSG_Running_Judging="تەكشۈرۈشتە...";
	$MSG_Accepted="مۇبارەك بولسۇن";
	$MSG_Presentation_Error="چىقىرىش خاتا ";
	$MSG_Wrong_Answer="جاۋاپ خاتا";
	$MSG_Time_Limit_Exceed="ۋاقىت چەكتىن ئاشتى ";
	$MSG_Memory_Limit_Exceed="ساقلىغۇچ چەكتىن ئاشتى";
	$MSG_Output_Limit_Exceed="چىقىرىش چەكتىن ئاشتى";
	$MSG_Runtime_Error="يۈرۈش خاتا";
	$MSG_Compile_Error="تەرجىمە خاتا";
	$MSG_Runtime_Click="يۈرۈش خاتا";
	$MSG_Compile_Click="تەرجىمە خاتا";
	$MSG_Compile_OK="تەرجىمە تامام";
	$MSG_Click_Detail="تەپسىلاتىنى كۆرۈش";
	$MSG_Manual="قولدا تەكشۈرۈش";
 	$MSG_OK="تامام";
 	$MSG_Explain="ھالەت ۋە چۈشەندۈرۈش";

//fool's day
if(date('m')==4&&date('d')==1&&rand(0,100)<10){
                 $MSG_Accepted="كاللىڭىزدا مەسىلە بار...ئالدامچىلار بايرىمىغا مۇبارەك";
	$MSG_Presentation_Error="كاللىڭىزدا مەسىلە بار...ئالدامچىلار بايرىمىغا مۇبارەك";
	$MSG_Wrong_Answer="كاللىڭىزدا مەسىلە بار...ئالدامچىلار بايرىمىغا مۇبارەك";
	$MSG_Time_Limit_Exceed="كاللىڭىزدا مەسىلە بار...ئالدامچىلار بايرىمىغا مۇبارەك";
	$MSG_Memory_Limit_Exceed="كاللىڭىزدا  مەسىلە بار...ئالدامچىلار بايرىمىغا مۇبارەك";
	$MSG_Output_Limit_Exceed="كاللىڭىزدا  مەسىلە بار...ئالدامچىلار بايرىمىغا مۇبارەك";
	$MSG_Runtime_Error="كاللىڭىزدا مەسىلە بار...ئالدامچىلار بايرىمىغا مۇبارەك";
	$MSG_Compile_Error="كاللڭىزدا  مەسىلە بار...ئالدامچىلار بايرىمىغا مۇبارەك";
	$MSG_Compile_OK="كاللىڭىزدا مەسىلە بار...ئالدامچىلار بايرىمىغا مۇبارەك";
}
//New year
if(date('m')==1 && date('d') == 1){
        $MSG_Accepted="يىڭى يىل مۇبارەك";
	$MSG_Presentation_Error="يىڭى يىل مۇبارەك";
	$MSG_Wrong_Answer="يىڭى يىل  مۇبارەك";
	$MSG_Time_Limit_Exceed=" يىڭى يىل مۇبارەك ";
	$MSG_Memory_Limit_Exceed="يىڭى يىل مۇبارەك ";
	$MSG_Output_Limit_Exceed="يىڭى يىل مۇبارەك ";
	$MSG_Runtime_Error="يىڭى يىل مۇبارەك";
	$MSG_Compile_Error="يىڭى يىل مۇبارەك";
	$MSG_Compile_OK="يىڭى يىل مۇبارەك";
}


	$MSG_TEST_RUN="ئۈلگە مۇۋەپپىقىيەتلىك ئۆتتى";

	$MSG_RUNID="يوللىنىش نۇمۇرى";
	$MSG_USER="ئابۇنىت";
	$MSG_PROBLEM="مەسىلە";
	$MSG_RESULT="نەتىجە";
	$MSG_MEMORY="سېغىم";
	$MSG_TIME="ۋاقىت";
	$MSG_LANG="تىل";
	$MSG_CODE_LENGTH="كود ئۇزۇنلۇقى";
	$MSG_SUBMIT_TIME="تەكشۈرگەن ۋاقىت";

	//problemstatistics.php
	$MSG_PD="كۈتۈۋاتىدۇ";
	$MSG_PR="قايتا تەكشۈرۈشنى كۈتۈۋاتىدۇ...";
	$MSG_CI="تەرجىمىلىنىۋاتىدۇ";
	$MSG_RJ="تەرجىمىدە";
	$MSG_AC="مۇبارەك بولسۇن";
	$MSG_PE="چىقىرىش خاتا";
	$MSG_WA="جاۋاپ خاتا";
	$MSG_TLE="ۋاقىت چەكتىن ئاشتى";
	$MSG_MLE="ساقلىغۇچ چەكتىن ئاشتى";
	$MSG_OLE="چىقىرىش چەكتىن ئاشتى";
	$MSG_RE="يۈرۈش خاتا";
	$MSG_CE="تەرجىمە خاتا";
	$MSG_CO="تەرجىمە تامام";
	$MSG_TR=" سىناق ";
	$MSG_RESET=" قايتا ";

	//problemset.php
	$MSG_SEARCH="ئىزدەش";
	$MSG_PROBLEM_ID="مەسلە نۇمۇرى";
	$MSG_TITLE="ماۋزۇ";
	$MSG_SOURCE="مەنبە";
	$MSG_SUBMIT="تاپشۇرۇش";

	//submit.php
	$MSG_VCODE_WRONG="Verification Code Wrong!";
	$MSG_LINK_ERROR="Where do find this link? No such problem.";
	$MSG_PROBLEM_RESERVED="Problem disabled.";
	$MSG_NOT_IN_CONTEST="You Can't Submit Now Because Your are not invited by the contest or the contest is not running!!";
	$MSG_NOT_INVITED="You are not invited!";
	$MSG_NO_PROBLEM="No Such Problem!";
	$MSG_NO_PLS="Using unknown programing language!";
	$MSG_TOO_SHORT="Code too short!";
	$MSG_TOO_LONG="Code too long!";
	$MSG_BREAK_TIME="You should not submit more than twice in 1 seconds.....";

	//ranklist.php
	$MSG_Number="نۇمۇر";
	$MSG_NICK="نامى";
	$MSG_SOVLED="يېشلگىنى";
	$MSG_RATIO="نىسبىتى";

	//registerpage.php
	$MSG_USER_ID="ئابۇنىت نۇمۇرى";
	$MSG_PASSWORD="مەخپى نۇمۇر";
	$MSG_REPEAT_PASSWORD="مەخپى نۇمۇرنى قايتىلاش";
	$MSG_SCHOOL="مەكتەپ";
	$MSG_EMAIL="ئېلخەت";
	$MSG_REG_INFO="رويىخەت ئۇچۇرى";
	$MSG_VCODE="دەلىللەش كودى ";

	//problem.php
	$MSG_NO_SUCH_PROBLEM="بۇ سوئال شەخسىيگە تەۋە،كۆرۈشكە رۇخسەت يوق";
	$MSG_Description="مەزمۇن";
	$MSG_Input="كىرگۈزۈش";
	$MSG_Output= "چىقىرىش";
	$MSG_Sample_Input= "ئۈلگە كىرگۈزۈش";
	$MSG_Sample_Output= "ئۈلگە چىقىرىش";
	$MSG_Test_Input= "سىناق كىرگۈزۈش" ;
	$MSG_Test_Output= "سىناق چىقىرىش" ;
	$MSG_SPJ= "ئالاھېدە تەكشۈرۈش" ;
	$MSG_HINT= "كۆرسەتمە";
	$MSG_Source= "مەنبە";
	$MSG_Time_Limit="ۋاقىت چەكلىمىسى";
	$MSG_Memory_Limit="ساقلىغۇچ چەكلىمىسى";
	$MSG_EDIT= "Edit";
	$MSG_TESTDATA= "TestDATA";

	//admin menu
	$MSG_SEEOJ="باش بەت";
	$MSG_ADD=" قوشۇش  ";
	$MSG_MENU="menu";
	$MSG_EXPLANATION="explanation";
	$MSG_LIST=" جەدۋەل ";
	$MSG_NEWS=" ئۇقتۇرۇش ";
	$MSG_CONTENTS="Contents";
	$MSG_SAVE="Save";	

	$MSG_TEAMGENERATOR=" گورۇپ نۇمۇرى چىقارغۇچ ";
	$MSG_SETMESSAGE=" ئۇچۇر يېزىش ";
	$MSG_SETPASSWORD=" مەخپى نۇمۇر ئۆزگەرتىش ";
	$MSG_REJUDGE=" قايتا تەكشۈرۈش ";
	$MSG_PRIVILEGE=" ھوقۇقدار ";
	$MSG_GIVESOURCE=" مەنبە يېزىش ";
	$MSG_IMPORT=" يوللاش ";
	$MSG_EXPORT=" چىقىرىش ";
	$MSG_UPDATE_DATABASE=" سان-سىپىرنى يېڭىلاش ";
	$MSG_ONLINE=" سىمدا ";
	$MSG_SET_LOGIN_IP="ئادېرسنى تەڭشەش IP ";
	$MSG_PRIVILEGE_TYPE="Privilege Type";

	//contest.php
  $MSG_PRIVATE_WARNING="مۇسابىقە باشلانمىدى ياكى سوئال شەخىسكە تەۋە";
	$MSG_PRIVATE_USERS_ADD="*Enter userIDs with newline, or you can copy and paste from a spreadsheet.";
	$MSG_PLS_ADD="*Please select all languages that can be submitted with Ctrl + click.";
	$MSG_TIME_WARNING="Before Contest Start";  
  $MSG_WATCH_RANK="بۇ يەرنى بىسىپ شەرەپ تاختىسىنى كۆرۈڭ";
  $MSG_NOIP_WARNING="مۇسابىقىسى ئاخىرلاشمىغىچە نەتىجىنى كۆرەلمەيسىز ".$OJ_NOIP_KEYWORD;

	$MSG_SERVER_TIME="SERVER TIME";
	$MSG_START_TIME="Start Time";
	$MSG_END_TIME="End Time";
	$MSG_CONTEST_ID="CONTEST ID";
	$MSG_CONTEST_NAME="CONTEST NAME";
	$MSG_CONTEST_STATUS="STATUS";
	$MSG_CONTEST_OPEN="OPEN";
	$MSG_CONTEST_CREATOR="CREATOR";
	$MSG_CONTEST_PENALTY="TIME PENALTY";
	$MSG_IP_VERIFICATION="IP VERIFICATION";
	$MSG_CONTEST_SUSPECT1="IP addresses with multiple IDs. If multiple IDs are accessed at the same computer during the contest/exam, it logged.";
	$MSG_CONTEST_SUSPECT2="IDs with multiple IP addresses. If switch to another computer during the contest/exam, it logged.";
		
	$MSG_SECONDS="seconds";
	$MSG_MINUTES="minutes";
	$MSG_HOURS="hours";
	$MSG_DAYS="days";
	$MSG_MONTHS="months";
	$MSG_YEARS="years";
	
  $MSG_Public="ئاشكارە";
  $MSG_Private="خۇسۇسىي";
  $MSG_Running=" ئىلىپ بېرىلىۋاتىدۇ ";
  $MSG_Start=" باشلاش ";
  $MSG_End=" ئاخىرلاش ";
  $MSG_TotalTime=" جەمئىي";
  $MSG_LeftTime=" قېپ قالغىنى ";
  $MSG_Ended=" تۈگىگىنى ";
  $MSG_Login=" ئالدى بىلەن تىزىملاڭ ";
  $MSG_JUDGER=" تەكشۈرگۈچ ";

  $MSG_SOURCE_NOT_ALLOWED_FOR_EXAM="سىناق مەزگىلىدە ئىلگىرىكى كودلارنى كۆرەلمەيسىز";
  $MSG_BBS_NOT_ALLOWED_FOR_EXAM="ئىمتاھان مەزگىلىدە مۇنازىرىلىشىشكە بولمايدۇ";
  $MSG_MODIFY_NOT_ALLOWED_FOR_EXAM="ئىمتاھان مەزگىلىدە ئابۇنىت ئۇچۇرىنى ئۆزگەرتىشكە بولمايدۇ";
  $MSG_MAIL_NOT_ALLOWED_FOR_EXAM="ئىمتاھان تۈگىمىگىچە ئېلخەت ئىشلىتىشكە بولمايدۇ";
  $MSG_LOAD_TEMPLATE_CONFIRM="ئىلگىرىكى نۇسخىنى چۈشۈرمەكچىمۇ\\n ئۇنداقتا سىز ھازىرقى كودىڭىزنى يۇيۇۋىتىسىز ";

  $MSG_BLOCKLY_OPEN="كۆرۈنمە";
  $MSG_BLOCKLY_TEST="كورۈنمە يۈرگۈزۈش";
  $MSG_MY_SUBMISSIONS=" تاپشۇرغىنىم";
  $MSG_MY_CONTESTS=" مۇسابىقەم";
  $MSG_Creator=" چىقارغۇچى ";
  $MSG_IMPORTED=" سىرىتتىن ";
  $MSG_PRINTER="پىرىنتېر ";
  $MSG_PRINT_DONE="پىرىتېرلاش تامام";
  $MSG_PRINT_PENDING=" پىرىتېرنى كۈتۈۋاتىدۇ ";
  $MSG_PRINT_WAITING=" سەۋىرچانلىق بىلەن كۈتۈپ تۇرۇڭ،قايتا بۇيرۇق بەرمەڭ ";
  $MSG_COLOR=" رەڭگى ";
  $MSG_BALLOON=" شار ";
  $MSG_BALLOON_DONE=" شار قويۇۋىتىلدى ";
  $MSG_BALLOON_PENDING=" شار تارقىتىلمىدى ";

  $MSG_HELP_SEEOJ="ئالدىنىقى بەتكە قايتىش  ";
  $MSG_HELP_ADD_NEWS="باش بەتكە ئۇقتۇرۇش يېزىش";
  $MSG_HELP_NEWS_LIST=" يېزىلغان ئۇقتۇرۇشلارنى تەھرېرلەش ";
  $MSG_HELP_USER_LIST=" ئابۇنىتچىلارنى باشقۇرۇش ";
  $MSG_HELP_USER_ADD="add user";
  $MSG_HELP_ADD_PROBLEM="ئالدى بىلەن سوئال قوشۇپ،كىيىن سىناق نۇقتىلىرىنى يوللىسىڭىز بولىدۇ ";
  $MSG_HELP_PROBLEM_LIST="قوشۇلۇپ بولغان سوئاللارنى تەھرىرلەش ياكى سىناق نۇقتىلىرىنى ئۆزگەرتىش";
  $MSG_HELP_ADD_CONTEST="مۇسابىقە ئورۇنلاشتۇرۇش.بۇنىڭدا سوئاللارنىڭ نۇمۇرى پەش بىلەن ئايرىلىدۇ.خۇسۇسىي ياكى ئاشكارە تەڭشەشكە،تەكلىپ كودى بىكىتىشكە ،قاتناشقۇچىلارنى بىكىتىشكە بولىدۇ";
  $MSG_HELP_CONTEST_LIST="مۇسابىقىلەر جەدۋىلى. مۇسابىقە ۋاقتىنى ياكى خاراكتېرىنى ئۆزگەرتىشكە تامامەن بولىدۇ،ئەمما مۇسابىقە باشلانغاندىن كىيىن يۇقارقى ئۇچۇرلارنى ئۆزگەرتمەڭ";
  $MSG_HELP_SET_LOGIN_IP="Record computer(login IP) changes during the exam.";
  $MSG_HELP_TEAMGENERATOR="تۈركۈملەپ ھېساب نۇمۇرى چىقىرىش.ئېھتىيات بىلەن ئىشلىتىڭ،ئەخلەت نۇمۇرلارنىڭ چىقىشىدىن ساقلىنىڭ";
  $MSG_HELP_SETMESSAGE="دومىلىما ئۇقتۇرۇش يېزىش";
  $MSG_HELP_SETPASSWORD=" مەخپى نۇمۇرنى قايتا تەڭشەش.باشقۇرغۇچى ئاۋال ئادەتتىكى ئابۇنىتچىغا ئايلىنىشى كىرەك";
  $MSG_HELP_REJUDGE="سوئال،مۇسابىقە،تاپشۇرۇشلارنى قايتا تەكشۈرۈش ";
  $MSG_HELP_ADD_PRIVILEGE="ئالاھېدە ئەزا ياكى ھوقۇق بىكىتىش مەسىلەن: administratorsباشقۇرغۇچى , subjectsكاتىپ , playersئوينىغۇچى, organizersتەشكىللىگۈچى, participantsقاتناشقۇچى, code viewerكود كۆرگۈچى, manual judge questions سوئال بىر تەرەپ قىلىش, remote questions&سوئال يۆتكەش   other permissionsباشقا ھوقوقلار ";
  $MSG_HELP_ADD_CONTEST_USER="Add User to private contest.";
	$MSG_HELP_ADD_SOLUTION_VIEW="Add Problem Solution View for User.";
  $MSG_HELP_PRIVILEGE_LIST= "ئالاھېدە ھوقوق چەكلىمىلەرنى تەڭشەش";
  $MSG_HELP_GIVESOURCE="بەزى ئابۇنىتلارغا ئۆلچەملىك كودنى كۆرۈش ھوقۇقى بىرىش،شۇ ئارقىلىق كودى ئۆتەلمىگەن ئابۇنىت مۇسابىقىدىن كىيىن ئۆلچەملىك كودنى ئۆگىنىشكە ياردەم بىرىش";
  $MSG_HELP_EXPORT_PROBLEM= " ھۆججىتى نۇسخىسىدا چىقىرىپ ساقلاشfps.xml سوئاللارنى ";
  $MSG_HELP_IMPORT_PROBLEM="ھۆججىتى سوئاللىرىنى كىرگۈزۈش ياكى توردىن سوئال ئىزدەش   fps.xml";
  $MSG_HELP_UPDATE_DATABASE= "سان-سىپىر ئامبىرىنى يېڭىلاش (ھەر قېتىم سىستېما يىڭىلىغاندا مۇشۇ بۇيرۇقنى يۈرگۈزۈڭ)";
  $MSG_HELP_ONLINE= "توردىكى ئابۇنىتلارنى كۆرۈش";
  $MSG_HELP_AC="مۇبارەك بولسۇن،كودىڭىز بارلىق سىناق نۇقتىلىرىدىن ئۆتتى. تېخىمۇ تېرىشىڭ";
  $MSG_HELP_PE="جاۋابىڭىز توغرا ئەمما فورماتى خاتا،جاۋابىڭىزنى تەپسىلى كۆررۈپ بېقىڭ.بوش كاتەك،بوش قۇرلار بولماسلىقى كىرەك";
  $MSG_HELP_WA="جاۋابىڭىز خاتا!!! ئۈلگە كىرگۈزۈش چىقىرىشتىنلا ئۆتكەن كود توغرا كود بولۇشى ناتايىن،تېخىمۇ ئىنچىكە ئويلىنىپ بېقىڭ،ئارقا سۇپىدا يەنە باشقا كىرگۈزۈش چىقىرىشلار بار";
  $MSG_HELP_TLE="كودىڭىز بەلگىلەنگەن چەكلىك ۋاقىت ئىچىدە بارلىق سىناق نۇقتىلىرىدىن ئۆتۈپ بولالمىدى";
  $MSG_HELP_MLE="كودىڭىز چەكلىمىدىن يۇقرى ئىچكى ساقلىغۇچ سەرىپ قىلدى";
  $MSG_HELP_OLE="كودىڭىز بەك كۆپ ئۇچۇر چىقاردى،تەپسىلى كۆرۈپ بېقىڭ ،ئادەتتە چىقىرىش 1 مىگابايىتتىن ئاشمايدۇ";
  $MSG_HELP_RE="يۈرۈش خاتا.گەرچە كودىڭىز توغرا تەرجىمە بولۇنسىمۇ،يۈرۈش جەريانىدا خاتالىق كۆرۈلدى.سەۋەبى بەلكىم تۆۋەندىكىچە:قائىدىگە ئىخلاپ ساقلىغۇچ زىيارىتى ياكى ئىندىكىس،چەكلەنگەن فۇنكىسىيەنى ئىشلىتىش،پويىنتېر ئۇچۇپ يۈرۈش ...";
  $MSG_HELP_CE="كودىڭىز تەرجىمىدە مەغلۇپ بولدى.كودىڭىزدا ئېغىر دەرجىدە تىل خاتالىق بار،بۇيەرنى چىكىپ تەپسىلاتىنى كۆرۈڭ";
  
	$MSG_HELP_MORE_TESTDATA_LATER="كۆپلىگەن سىناق نۇقتىلىرىنى سوئال كىرگۈزۈپ بولغاندىن كىيىن قوشۇش";
  $MSG_HELP_ADD_FAQS="Add a news which titled \"faqs.$OJ_LANG\", it apears as <a href=../faqs.php>$MSG_FAQ</a>";
	$MSG_HELP_HUSTOJ="<sub><a target='_blank' href='https://github.com/zhblue/hustoj'><span class='glyphicon glyphicon-heart' aria-hidden='true'></span> Please give us a <span class='glyphicon glyphicon-star' aria-hidden='true'></span>Star @HUSTOJ Github!</a></sub>";
  $MSG_HELP_SPJ="<a href='https://cn.bing.com/search?q=hustoj+special+judge' target='_blank'>ئىزدەڭ hustoj special judge</a>تېخىمۇ كۆپ تەپسىلات ";
  $MSG_HELP_BALLOON_SCHOOL="پىرىنتېر ۋە شار ئۈچۈن مەكتەپ نامى سۈزۈۋىتىلىدۇ";

  $MSG_WARNING_LOGIN_FROM_DIFF_IP="ئادىرىستىن تىزىملاپ كىرىشip ئوخشىمىغان";
  $MSG_WARNING_DURING_EXAM_NOT_ALLOWED=" ئىمتاھان ۋاقتىدا رۇخسەت يوق  ";
  $MSG_WARNING_ACCESS_DENIED="I am sorry, You could not view this message! Because it's not belong to you, or Administrator won't show you.";

  $MSG_LOSTPASSWORD_MAILBOX="  دەلىللەش كودىنى ئېلخېتىڭىزگە يوللاندى،تەكشۈرۈپ ئېلىڭ";
  $MSG_LOSTPASSWORD_WILLBENEW=" ئەگەر توغرا بولسا ،كىيىنكى قەدەمدە مۇقۇملاش ئارقىلىق دەلىللەش كودى سىزنىڭ يېڭى مەخپى شىفىرىڭىزگە ئايلىنىدۇ";


  // template/../reinfo.php
  $MSG_A_NOT_ALLOWED_SYSTEM_CALL="Use the operating system calls prohibited by the system to see if you have unauthorized access to resources such as files or processes. If you are a system administrator and confirm that there is no problem with the submitted answer and the test data has no problem, you can send'RE' to the WeChat official account onlinejudge, view the solution.";
  $MSG_SEGMETATION_FAULT="Check whether the array is out of bounds, the pointer is abnormal, and the memory area that should not be accessed is accessed.";
  $MSG_FLOATING_POINT_EXCEPTION="Floating point error, check for division by zero.";
  $MSG_BUFFER_OVERFLOW_DETECTED="Buffer overflow, check whether the string length exceeds the array.";
  $MSG_PROCESS_KILLED="The process is killed because of memory or time, check whether there is an infinite loop.";
  $MSG_ALARM_CLOCK="The process was killed due to time. Check whether there is an infinite loop. This error is equivalent to timeout TLE.";
  $MSG_CALLID_20="The array may be out of bounds, check the relationship between the amount of data described in the title and the size of the applied array.";
  $MSG_ARRAY_INDEX_OUT_OF_BOUNDS_EXCEPTION="Check if the array is out of bounds.";
  $MSG_STRING_INDEX_OUT_OF_BOUNDS_EXCEPTION="The character subscript of the string is out of range, check the parameters of subString, charAt and other methods.";

	// template/../ceinfo.php
	$MSG_ERROR_EXPLAIN="Expain";
	$MSG_SYSTEM_OUT_PRINT="The usage of System.out.print in Java is different from that of C language printf, please try System.out.format";
	$MSG_NO_SUCH_FILE_OR_DIRECTORY="The server is a Linux system and cannot use non-standard header files unique to Windows.";
	$MSG_NOT_A_STATEMENT="Check the matching of braces {}, eclipse sorts the code shortcut key Ctrl+Shift+F";
	$MSG_EXPECTED_CLASS_INTERFACE_ENUM="Please do not place java functions (methods) outside the class declaration, pay attention to the ending position of the braces }";
	$MSG_SUBMIT_JAVA_AS_C_LANG="Please do not submit java program as C language.";
	$MSG_DOES_NOT_EXIST_PACKAGE="Check spelling, such as: the system object System starts with a capital S";
	$MSG_POSSIBLE_LOSS_OF_PRECISION="Assignment will lose precision, check the data type, if it is correct, you can use coercive type conversion.";
	$MSG_INCOMPATIBLE_TYPES="Different types of data in Java cannot be assigned to each other, and integers cannot be used as Boolean values.";
	$MSG_ILLEGAL_START_OF_EXPRESSION="String should be surrounded by English double quotation marks (\\\")";
	$MSG_CANNOT_FIND_SYMBOL="Misspelling or missing objects required to call the function such as println() need to call System.out";
	$MSG_EXPECTED_SEMICOLON="The semicolon is missing.";
	$MSG_DECLARED_JAVA_FILE_NAMED="Java must use public class Main.";
	$MSG_EXPECTED_WILDCARD_CHARACTER_AT_END_OF_INPUT="The code is not over, missing matching brackets or semicolons, check whether all the codes are selected when copying.";
	$MSG_INVALID_CONVERSION="The implicit type conversion is invalid, try to use explicit coercion such as (int *)malloc(....)";
	$MSG_NO_RETURN_TYPE_IN_MAIN="In the C++ standard, the main function must have a return value.";
	$MSG_NOT_DECLARED_IN_SCOPE="The variable has not been declared, check for spelling errors!";
	$MSG_MAIN_MUST_RETURN_INT="In the standard C language, the return value type of the main function must be int, and the use of void in teaching materials and VC is a non-standard usage.";
	$MSG_PRINTF_NOT_DECLARED_IN_SCOPE="The printf function is called without a declaration, and check whether the <stdio.h> or <cstdio> header file is imported.";
	$MSG_IGNOREING_RETURN_VALUE="Warning: Ignore the return value of the function, it may be that the function is used incorrectly or the return value is not considered abnormal.";
	$MSG_NOT_DECLARED_INT64="__int64 is not declared. The __int64 in Microsoft VC is not supported in standard C/C++, please use long long to declare 64-bit variables.";
	$MSG_EXPECTED_SEMICOLON_BEFORE="The semicolon is missing from the previous line.";
	$MSG_UNDECLARED_NAME="Variables must be declared before they are used, or they may be spelled incorrectly. Pay attention to case sensitivity.";
	$MSG_SCANF_NOT_DECLARED_IN_SCOPE="The scanf function is called without being declared, and check whether the <stdio.h> or <cstdio> header file is imported.";
	$MSG_MEMSET_NOT_DECLARED_IN_SCOPE="The memset function is called without being declared, and check whether the <stdlib.h> or <cstdlib> header file is imported.";
	$MSG_MALLOC_NOT_DECLARED_IN_SCOPE="The malloc function is called without being declared, and check whether the <stdlib.h> or <cstdlib> header file is imported.";
	$MSG_PUTS_NOT_DECLARED_IN_SCOPE="The puts function is called without being declared, and check whether the <stdio.h> or <cstdio> header file is imported.";
	$MSG_GETS_NOT_DECLARED_IN_SCOPE="The gets function is called without being declared, and check whether the <stdio.h> or <cstdio> header file is imported.";
	$MSG_STRING_NOT_DECLARED_IN_SCOPE="The string function is called without being declared, and check whether the <string.h> or <cstring> header file is imported.";
	$MSG_NO_TYPE_IMPORT_IN_C_CPP="Don't submit Java language programs as C/C++, please choose the language type before submitting.";
	$MSG_ASM_UNDECLARED="It is not allowed to embed assembly language code in C/C++.";
	$MSG_REDEFINITION_OF="The function or variable is repeatedly defined, and see if the code is pasted multiple times.";
	$MSG_EXPECTED_DECLARATION_OR_STATEMENT="The program does not seem to be finished. Check if the code is missing when copying and pasting.";
	$MSG_UNUSED_VARIABLE="Warning: Variables are not used after declaration. Check for spelling errors and misuse variables with similar names.";
	$MSG_IMPLICIT_DECLARTION_OF_FUNCTION="Function implicit declaration, check whether the correct header file is imported. Or the function with the specified name required by the title is missing.";
	$MSG_ARGUMENTS_ERROR_IN_FUNCTION="The number of parameters provided in the function call is incorrect. Check whether the wrong parameters are used.";
	$MSG_EXPECTED_BEFORE_NAMESPACE="Don't submit C++ language program as C, please choose the language type before submitting.";
	$MSG_STRAY_PROGRAM="Chinese spaces, punctuation, etc. cannot appear in the program other than comments and character strings. Please close the Chinese input method when writing a program. Please do not use the code copied from the Internet.";
	$MSG_DIVISION_BY_ZERO="Division by zero will cause a floating point overflow.";
	$MSG_CANNOT_BE_USED_AS_A_FUNCTION="Variables cannot be used as functions. Check for duplicates of variable and function names, or spelling errors.";
	$MSG_CANNOT_FIND_TYPE="The format description of scanf/printf is inconsistent with the following parameter list. Check whether there is more or less address character \\\"&\\\", or it may be a spelling error.";
	$MSG_JAVA_CLASS_ERROR="Java language submission can only have one public class, and the class name must be Main, please do not use public keywords for other classes.";
	$MSG_EXPECTED_BRACKETS_TOKEN="Missing closing brackets";
	$MSG_NOT_FOUND_SYMBOL="Use an undefined function or variable, check whether the spelling is wrong, do not use a non-existent function, Java call methods usually need to give the object name such as list1.add(...). Java method calls are sensitive to parameter types, such as: cannot pass an integer (int) to a method that accepts a string object (String).";
	$MSG_NEED_CLASS_INTERFACE_ENUM="Keyword is missing, it should be declared as class, interface or enum.";
	$MSG_CLASS_SYMBOL_ERROR="To use the examples on the textbook, you must submit the relevant code and remove the public keyword.";
	$MSG_INVALID_METHOD_DECLARATION="Only the method with the same class name is the constructor, and the return value type is not written. If you change the class name to Main, please also change the name of the constructor.";
	$MSG_EXPECTED_AMPERSAND_TOKEN="Don't submit C++ language program as C, please choose the language type before submitting.";
	$MSG_DECLARED_FUNCTION_ORDER="Please pay attention to the order of the declaration of functions and methods. The declaration of another method cannot appear in one method.";
	$MSG_NEED_SEMICOLON="The line marked above lacks a semicolon at the end.";
	$MSG_EXTRA_TOKEN_AT_END_OF_INCLUDE="The include statement must be on its own line and cannot be placed on the same line as the following statement";
	$MSG_INT_HAS_NEXT="hasNext() should be changed to nextInt()";
	$MSG_UNTERMINATED_COMMENT="The comment is not over, please check whether the ending character \\\"*/\\\" corresponding to \\\"/*\\\" is correct";
	$MSG_EXPECTED_BRACES_TOKEN="Function declaration lacks parentheses (), such as int main() written as int main";
	$MSG_REACHED_END_OF_FILE_1="Check whether the submitted source code is not copied intact, or the closing brace is missing.";
	$MSG_SUBSCRIPT_ERROR="Cannot perform subscript access to non-array or pointer variables";
	$MSG_EXPECTED_PERCENT_TOKEN="The format part of scanf needs to be enclosed in double quotes";
	$MSG_EXPECTED_EXPRESSION_TOKEN="The parameter or expression is not finished";
	$MSG_EXPECTED_BUT="Wrong punctuation or symbols.";
	$MSG_REDEFINITION_MAIN="This question may be an additional code question. Please review the question again to see the meaning of the question. Do not submit the main function defined by the system, but submit a function in the specified format.";
	$MSG_IOSTREAM_ERROR="Please do not submit C++ programs as C.";
	$MSG_EXPECTED_UNQUALIFIED_ID_TOKEN="Pay attention to whether the semicolon is missing after the array declaration.";
	$MSG_REACHED_END_OF_FILE_2="Missing braces at the end of the program.";
	$MSG_INVALID_SYMBOL="Check if Chinese punctuation or spaces are used.";
	$MSG_DECLARED_FILE_NAMED="The public class in OJ can only be Main.";
	$MSG_EXPECTED_IDENTIFIER="It may not have declare a variable name or missing parentheses when declaring a variable.";
	$MSG_VARIABLY_MODIFIED="Variables cannot be used for array size. Variables cannot be used as the dimension size of global arrays in C language, including const variables.";


 ?>
