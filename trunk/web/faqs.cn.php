<?php
	require_once('oj-header.php'); 
	require_once("./include/db_info.inc.php");
?>
<hr>
<center>
  <font size="+3"><?=$OJ_NAME?> Online Judge FAQ</font>
</center>
<hr>

		<div class="postbody"><strong style="FONT-SIZE: 18pt">PKU JudgeOnline FAQ 中文版</strong>
<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --oyjpArt<br><br>常见问题解答<br>1.&nbsp;我的程序如何进行输入输出?<br>2.&nbsp;在线判题系统(以下简称POJ)的编译器是哪些?<br>3.&nbsp;提交的时候可否使用快捷键?<br>4.&nbsp;请问提交的程序是如果被判答的?<br>5.&nbsp;POJ对提交程序的不同判答的意义?<br>6.&nbsp;Special Judge的题目有什么不同?<br>7.&nbsp;如何确定程序读入的终止?<br>8.&nbsp;为什么我的程序在GCC/G++ (C/C++)下被判成WA/TLE/RE,但是在C/C++ (GCC/G++)下被判成AC?<br>9.&nbsp;有些题目的时间限制是1秒,但是有些程序却以几秒的时间AC了?<br>10.&nbsp;我的程序仅仅超过时间限制15MS,我该怎么优化程序呢?<br>11.&nbsp;我还有其他问题?<br>________________________________________</p>
<p>问题: 我的程序如何进行输入输出?<br>解答: 你的程序应该始终使用标准输入(stdin)和标准输出(stdout).比如,你可以使用scanf(在C/C++编</p>
<p>译器下)或者cin(在C++编译器下)来读取数据,使用printf(在C/C++编译器下)或者cout(在C++编译器下)</p>
<p>来输出答案.用户提交的程序将不允许读/写文件操作.如果你坚持要这样做,OJ很可能会返回Runtime </p>
<p>Error(运行时错误)或者Wrong Answer(答案错误).<br>另外还要注意的是在C++下的I/O操作.由于其复杂的内部实现方式,cin和cout相对于scanf和printf来说</p>
<p>要慢上不少.如果在G++下编译提交,速度的差异将会愈加明显.所以如果题目给出的数据将有巨大的输入</p>
<p>数据时,使用cin和cout有可能导致意外的Time Limit Exceed(超时).<br>________________________________________</p>
<p>问题: 在线判题系统的编译器是哪些?<br>解答: 目前我们使用5个编译器来支持各种语言的程序提交.C和C++采用的是MS-VC++ 6.0,而对于</p>
<p>GCC/G++,采用的是MinGW+GCC/G++ 3.4.2. 对于Pascal, 采用的是FreePascal 2.0.0. 对于Java, 采用的</p>
<p>是JDK 1.5.0.<br>下面是1000的正确程序在不同编译器下的写法:<br>　<br>C and GCC:<br>#include &lt;stdio.h&gt;<br>　<br>int main(void)<br>{<br>&nbsp;&nbsp;&nbsp; int a, b;<br>&nbsp;&nbsp;&nbsp; scanf("%d %d", &amp;a, &amp;b);<br>&nbsp;&nbsp;&nbsp; printf("%d\n", a + b);<br>&nbsp;&nbsp;&nbsp; return 0;<br>}<br>　<br>C++ and G++:<br>#include &lt;iostream&gt;<br>　<br>using namespace std;<br>　<br>int main(void)<br>{<br>&nbsp;&nbsp;&nbsp; int a, b;<br>&nbsp;&nbsp;&nbsp; cin &gt;&gt; a &gt;&gt; b;<br>&nbsp;&nbsp;&nbsp; cout &lt;&lt; a + b &lt;&lt; endl;<br>&nbsp;&nbsp;&nbsp; return 0;<br>}<br>　<br>使用GCC/G++的提醒:<br>对于64位整数, long long int 和 __int64 都是支持并且等价的.但是在读和写的时候只支持scanf("%</p>
<p>I64d", ...)和printf("%I64d", ...).<br>不支持"%lld"是因为MinGW下的GCC和G++使用的msvcrt.dll动态链接库并不支持C99标准.<br>根据ISO C++标准,在G++下,main函数的返回值必须是int,否则将会导致Compile Error(编译错误)的判答</p>
<p>.<br>　<br>Pascal:<br>Program p1000(Input, Output); <br>Var <br>&nbsp;&nbsp;&nbsp; a, b: Integer; <br>　 <br>Begin<br>&nbsp;&nbsp;&nbsp; Readln(a, b); <br>&nbsp;&nbsp;&nbsp; Writeln(a + b); <br>End.<br>　<br>Java: <br>import java.util.*;<br>　<br>public class Main<br>{<br>&nbsp;&nbsp;&nbsp; public static void main(String args[])<br>&nbsp;&nbsp;&nbsp; {<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Scanner cin = new Scanner(System.in);<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; int a = cin.nextInt(), b = cin.nextInt();<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; System.out.println(a + b);<br>&nbsp;&nbsp;&nbsp; }<br>}<br>　<br>使用JAVA的提醒:<br>Java程序的提交必须使用单个源文件.除了要遵守其他程序提交的规则之外,使用Java提交的程序还必须</p>
<p>从一个静态的main方法开始执行,并让该main方法置于一个名为Main的类中,否则将会导致Compile </p>
<p>Error(编译错误)的判答.遵守了上述规则的情况下,你可以实现和初始化任意需要的类.<br>在JDK 1.4下的一个标准程序如下:<br>import java.io.*;<br>import java.util.*;</p>
<p>public class Main<br>{<br>&nbsp;&nbsp;&nbsp; public static void main (String args[]) throws Exception<br>&nbsp;&nbsp;&nbsp; {<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; BufferedReader stdin = <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; new BufferedReader(<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; new InputStreamReader(System.in));</p>
<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; String line = stdin.readLine();<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; StringTokenizer st = new StringTokenizer(line);<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; int a = Integer.parseInt(st.nextToken());<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; int b = Integer.parseInt(st.nextToken());<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; System.out.println(a + b);<br>&nbsp;&nbsp;&nbsp; }<br>}<br>　<br>________________________________________</p>
<p>问题: 提交的时候可否使用快捷键?<br>解答: 以下是提交页面的快捷键<br>ALT+s&nbsp;提交<br>ALT+u &nbsp;用户名域(如果你还没有登陆)<br>ALT+l &nbsp;编译语言选项<br>ALT+p &nbsp;提交的题目ID号<br>________________________________________</p>
<p>问题: 请问提交的程序是如果被判答的?<br>解答: POJ首先将你提交的程序存为文件,然后试图按照你选择的编译语言进行编译.如果编译出现错误,</p>
<p>将会判答Compile Error.然后POJ运行您的程序,将输入数据送入程序,并且开始计时(记录程序的运行时</p>
<p>间).输入数据储存在一个或多个输入文件中.每一个文件都会用来判定你的程序并且只使用一次.在程序</p>
<p>执行过程中,如果POJ发现你的程序的运行状态符合Runtime Error, Time Limit Exceed, Memory Limit </p>
<p>Exceed 或者 Output Limit Exceed的标准,这些判答就会返回并结束.这意味着在TLE或者MLE的情况下,</p>
<p>不能确定程序是否能在充裕的硬件和时间条件下得到正确的结果.当你的程序跑完一个输入文件时,POJ将</p>
<p>会对你的输出文件和相应标准输出文件进行比较,或者在Speical Judge的题目时进行Special Judge.如</p>
<p>果输出是不正确的且不满足Presentation Error,将会给与Wrong Answer判答并结束.否则POJ将会继续进</p>
<p>行下一个输入文件的运行和处理.如果所有的输入文件都已结束,如果整个过程中没有遇到上述的6种错误</p>
<p>但是输出的符合Presentation Error的条件,将会给与Presentation Error的判答并结束.否则,恭喜</p>
<p>您,Accepted将会判答.<br>________________________________________</p>
<p>问题: POJ对提交程序的不同判答的意义?<br>解答: 下面是POJ所有的判答结果,缩写,和准确含义<br>Waiting: 你的程序正在被判答或者在等待判答.<br>　<br>Accepted (AC): 恭喜!您顺利通过了本题的所有测试数据!<br>　<br>Presentation Error (PE): 你的程序的输出格式和题目所要求的不是完全一致,但是输出的数据是正确</p>
<p>的.这一般是白字符(空格,tab和/或换行等白字符)的缺少或者多余或者空行的缺少多余所导致的.每行的</p>
<p>结尾的空格和输出的末尾空行不会被判成PE.请仔细检查输出的空格,空行等是否与要求的输出完全一致.</p>
<p>Wrong Answer (WA): 你的程序没有输出正确的答案。为了简化判答，如果是Secial Judge的题目,本该</p>
<p>判Presentation Error的程序也可能返回Wrong Answer.<br>　<br>Runtime Error (RE): 你的程序在执行过程中崩溃了. 可能的原因包括:非法文件访问,栈溢出,数组越界</p>
<p>,浮点异常,除零运算等等. 程序长时间不响应也可能被认为是发生了Runtime Error.<br>　<br>Time Limit Exceed (TLE): 你的程序运行的总时间超过了时间限制.每个题目有2个时间限制,即TOTAL </p>
<p>TIME LIMIT（总运行时间限制）和 CASE TIME LIMIT（一次运行时间限制）.前者是你的程序运行所有的</p>
<p>输入文件数据的总时间限制,后者则是运行单个数据输入文件的限制. 两者之中只要有一个超时,就会导</p>
<p>致判答Time Limit Exceed. 如果你的程序被判答Time Limit Exceed,但是并没有超过总运行时间限制,</p>
<p>那就说明你的程序超过了一次运行时间限制.<br>如果题目没有特殊说明CASE TIME LIMIT, 那么将默认设置为与TOTAL TIME LIMIT相同的值,并且不会在</p>
<p>题目中显示出来.</p>
<p>Memory Limit Exceed (MLE): 你的程序使用的最大内存超过了内存限制.<br>　<br>Output Limit Exceed (OLE): 你的程序的输出超过了文本输出大小限制.目前文本输出大小限制被设置</p>
<p>为标准输出大小的2倍.最主要的原因是你的程序在包含输出的语句中陷入了无限循环的错误.</p>
<p>Compile Error (CE): 编译器在编译你的程序的时候发生了错误.警告信息不会被认为是错误.单击POJ对</p>
<p>你的程序的判答结果,可以看到编译器产生的错误和警告信息.<br>　<br>No such problem: 你提交的程序不存在或者不可用.<br>　<br>System Error: 你的程序无法运行.举例:你的程序需要比当前硬件条件下的内存多得多的空间.<br>　<br>Validate Error: Speical Judge程序无法正确检验你的输出文件. 可能是Special Judge程序有错.如果</p>
<p>你的程序被判答Validate Error,请尽快通知管理员.(当然,这也意味着你的程序很可能是错误的).<br>________________________________________</p>
<p>问题: Special Judge的题目有什么不同?<br>解答: 但一个题目可以接受多种正确答案,即有多组解的时候,题目就必须被Special Judge．<br>Special　Judge程序使用输入数据和一些其他信息来判答你程序的输出，并将判答结果返回．</p>
<p>________________________________________</p>
<p>问题: 如何确定程序读入的终止?<br>解答: 大部分情况下，题目会在input中清晰地描叙输入数据如何结束，比如，test cases的数目或者一</p>
<p>行全零的数据，等等．但是，有时候你必须用EOF结束符来确认文件的结尾．在这种情况下，你必须检查</p>
<p>scanf的返回值（返回有多少个值被成功的读入或者为0时返回EOF),对于cin,则可以类似的通过　!cin来</p>
<p>确认．你可以参考Problem 1001的Hint进一步了解如果确定程序读入的终止．<br>________________________________________</p>
<p>问题: 为什么我的程序在GCC/G++ (C/C++)下被判成WA/TLE/RE,但是在C/C++ (GCC/G++)下被判成AC?<br>解答: 很可能是因为你的程序里的一些微小错误在不同编译器的因素下导致的不同判答。我们建议您仔</p>
<p>细检查您的代码以找到错误。另外一个可能的原因就是不同的编译器往往使用不用的函数，库，和设置</p>
<p>来生成可执行文件。所以在特殊情况下，有可能不同编译器下生成的可执行程序会有不同的执行效率或</p>
<p>者执行结果。比如，MS-VC++的栈的大小比在G++下的栈要大。一个具有很深的递归的程序就可能出现暴</p>
<p>栈的情况。如果你很肯定地认为你的程序在不同编译器下判答的差异是由编译器造成的，请联系我们。<br>________________________________________</p>
<p>问题: 有些题目的时间限制是1秒,但是有些程序却以几秒的时间AC了?<br>解答: 大部分这样的程序是Java程序。众所周知，Java程序的运行速度比C/C++程序要慢很多。所以对于</p>
<p>Java程序的时间限制也要长于普通时限。确切的说，Java程序允许运行的运行时限是普通时限的3倍。而</p>
<p>且给于150MS的多于时间作为I/O速度慢的补偿。如果你的程序不满足上述条件，请联系我们。<br>　<br>________________________________________</p>
<p>问题: 我的程序仅仅超过时间限制15MS,我该怎么优化程序呢?<br>解答: 大部分情况下，你的程序实际上需要比时限多较多的时间来运行。POJ会在题目的时限到达的时候</p>
<p>自动终止你的程序。通常超时的程序会显示超过时限15MS。一般的优化程序技巧包括缩小算法的常数和</p>
<p>采用更加有效的算法。<br>________________________________________</p>
<p>问题: 我还有其他问题?<br>解答: 您可以充分利用我们的BBS系统来提问。请您用较和气的口吻来提问，管理员和其他人都会尽可能</p>
<p>来帮助你。</p>
<hr>
from http://www.cppblog.com/sicheng/archive/2007/11/22/37114.html
<center>
  <font color=green size="+2">Any questions/suggestions please post to <a href="bbs.php"><?=$OJ_NAME?> BBS</a></font>
</center>
<hr>
<center>
  <table width=100% border=0>
    <tr>
      <td align=right width=65%>
      <a href = "index.php"><font color=red><?=$OJ_NAME?></font></a> 
      <a href = "http://code.google.com/p/hustoj/source/detail?r=534"><font color=red>R534</font></a></td>
    </tr>
  </table>
</center>
<?php require_once('oj-footer.php');?>
