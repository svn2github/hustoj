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
?>
