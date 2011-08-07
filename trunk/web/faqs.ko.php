<?php
$cache_time=3600;
$OJ_CACHE_SHARE=false;
	require_once('oj-header.php'); 
	require_once("./include/db_info.inc.php");
?>
<hr>
<center>
  <font size="+3">HUST Online Judge FAQ</font>
</center>
<hr>
<p><font color=green>Q</font>:채점을 위해 사용되는 컴파일러와 각 컴파일러의 옵션은 어떤것입니까?<br>
  <font color=red>A</font>:채점 시스템은 <a href="http://www.debian.org/">Debian Linux</a>에서 구동됩니다. 현재 C/C++ 코드 컴파일을 위해 <a href="http://gcc.gnu.org/">GNU GCC/G++</a>를 사용하고 있으며, pascal 코드 컴파일을 위해 <a href="http://www.freepascal.org">Free Pascal</a> 을, 그리고 Java 코드 컴파일을 위해  <a href="http://www.oracle.com/technetwork/java/index.html">sun-java-jdk1.6</a>를 사용합니다. 컴파일을 위해서 다음과 같은 옵션을 사용합니다:<br>
</p>
<table border="1">
  <tr>
    <td>C:</td>
    <td><font color=blue>gcc Main.c -o Main -ansi -fno-asm -O2 -Wall -lm --static</font></td>
  </tr>
  <tr>
    <td>C++:</td>
    <td><font color=blue>g++ Main.c -o Main -ansi -fno-asm -O2 -Wall -lm --static</font></td>
  </tr>
  <tr>
    <td>Pascal:</td>
    <td><font color=blue>fpc Main.pas -oMain -O1 -Co -Cr -Ct -Ci </font></td>
  </tr>
  <tr>
    <td>Java:</td>
    <td><font color="blue">javac Main.java</font></td>
  </tr>
</table>
<p> 현재 사용되는 각 컴파일러의 버전:<br>
  <font color=blue>gcc/g++  4.1.2 20061115 (prerelease) (Debian 4.1.1-21)</font><br>
  <font color=blue>glibc 2.3.6</font><br>
<font color=blue>Free Pascal Compiler version 2.0.0 [2005/09/09] for i386<br>
Java 1.6.0_06<br>
</font></p>
<hr>
<font color=green>Q</font>:입력과 출력은 어떻게 받나요?<br>
<font color=red>A</font>:채점을 위해서 입력은 stdin('Standard Input')을 통해 받게 되며, stdout('Standard Output')에 출력하게 됩니다. 자세하게 이야기 하자면, 입력을 위해서는 'scanf(C)/cin(C++)'을, 출력을 위해서 'printf(C)/cout(C++)' 을 사용하게 됩니다<br>
사용자가 작성한 프로그램은 파일을 읽고 쓰는 것이 금지 되어 있으며, 이러한 경우, "<font color=green>Runtime Error</font>" 를 받게 됩니다.<br><br>
다음은 1000번 문제를 C++를 이용하여 푼 예시코드입니다.:<br>
<pre><font color="blue">
#include &lt;iostream&gt;
using namespace std;
int main(){
    int a,b;
    while(cin >> a >> b)
        cout << a+b << endl;
	return 0;
}
</font></pre>
C를 이용하여 100번 문제를 짠 예시 코드입니다:<br>
<pre><font color="blue">
#include &lt;stdio.h&gt;
int main(){
    int a,b;
    while(scanf("%d %d",&amp;a, &amp;b) != EOF)
        printf("%d\n",a+b);
	return 0;
}
</font></pre>
PASCAL은 다음과 같이 작성할 수 있습니다.:<br>
<pre><font color="blue">
program p1001(Input,Output); 
var 
  a,b:Integer; 
begin 
   while not eof(Input) do 
     begin 
       Readln(a,b); 
       Writeln(a+b); 
     end; 
end.
</font></pre>
<br><br>

마지막으로 Java를 이용한 코드입니다:<br>
<pre><font color="blue">
import java.util.*;
public class Main{
	public static void main(String args[]){
		Scanner cin = new Scanner(System.in);
		int a, b;
		while (cin.hasNext()){
			a = cin.nextInt(), b = cin.nextInt();
			System.out.println(a + b);
		}
	}
}</font></pre>

<hr>
<font color=green>Q</font>:제가 테스트 해보았을 떄는 잘 돌아가는데 결과로 Compile Error가 뜹니다. 왜그럴까요?<br>
<font color=red>A</font>:일반적으로 MS-VC++를 사용하였을 경우에 발생하며, GNU와 MS-VC++에서 생기는 차이점에 의하여 발생합니다. 예를 들면 다음과 같습니다:<br>
<ul>
  <li>G++에선 <font color=blue>main</font>이 반드시 <font color=blue>int</font>형으로 선언되어야 하며, <font color=blue>void main</font>을 사용하게 되면 Compile Error를 받게 됩니다..<br> 
  <li><font color=blue>for</font>(<font color=blue>int</font> <font color=green>i</font>=0...){...}"와 같이 for문 안에 int변수를 선언하였을 경우 block을 벗어났을 때 i 변수는 사라지게 됩니다.<br>
  <li><font color=green>itoa</font> 는 ANSI 에서 규정한 표준 함수가 아닙니다.<br>
  <li>VC에서의 <font color=green>__int64</font>는 ANSI 표준이 아닙니다. 하지만 64비트 integer 변수를 사용하기 위해 <font color=blue>long long</font>을 사용할 수 있습니다.<br>
</ul>
<hr>
<font color=green>Q</font>:채점 결과의 뜻은 무엇인가요?<br>
<font color=red>A</font>:채점결과들의 의미는 다음과 같습니다:<br>
<p><font color=blue>Pending</font> : 채점이 밀려서 아직 채점이 완료 되지 않은 대기 상태. 일반적으로 1분 이내에 채점이 됩니다.  </p>
<p><font color=blue>Pending Rejudge</font>: 테스트 데이터를 새로이 고치거나 했을 경우, 해당 제출 코드를 다시 채점하게 되어 대기 상태로 들어가는 경우.</p>
<p><font color=blue>Compiling</font> : 채점을 하기 위해 컴파일 하는 중에 나타납니다.<br>
</p>
<p><font color="blue">Running &amp; Judging</font>: 채점이 진행되고 있음을 의미합니다.<br>
  </p>
<p><font color=blue>Accepted</font> : 제출한 프로그램이 모든 테스트 데이터를 통과했음을 뜻합니다.<br>
  <br>
  <font color=blue>Presentation Error</font> : 출력 결과가 테스트 데이터와 유사하나, 공백, 빈 줄과 같은 사소한 문제로 인해 출력 결과가 일치하지 않는 경우입니다.<br>
  <br>
  <font color=blue>Wrong Answer</font> : 출력 결과가 테스트 데이터와 다른 경우 입니다.<br>
  <br>
  <font color=blue>Time Limit Exceeded</font> : 제출한 프로그램이 제한된 시간이내에 끝나지 않은 경우를 뜻합니다.<br>
  <br>
  <font color=blue>Memory Limit Exceeded</font> : 제출한 프로그램이 허용된 메모리보다 많은 메모리를 사용했을 경우를 뜻합니다.  <br>
  <br>
  <font color=blue>Output Limit Exceeded</font>: 예상하는 보다 많은 출력이 발생한 경우 입니다. 일반적으로 프로그램이 무한 루프에 빠졌을 경우에 일어납니다. 현재 채점 시스템에서 출력 제한은 1메가 바이트로 제한됩니다.<br>
  <br>
  <font color=blue>Runtime Error</font> : 실행 도중에 'segmentation fault','floating point exception','used forbidden functions', 'tried to access forbidden memories' 등의 에러가 발생하여서 실행도중에 프로그램이 종료된 경우 입니다.<br>
</p>
<p>  <font color=blue>Compile Error</font> : 컴파일러가 제출한 소스코드를 컴파일 하지 못한 경우입니다. 물론 경고 메시지(warning message)는 에러 메시지로 간주하지 않습니다. 채점 결과를 클릭하면 실제 에러 메시지를 볼 수 있습니다.<br>
  <br>
</p>
<hr>
<font color=green>Q</font>:온라인 대회에 어떻게 참가하죠?<br>
<font color=red>A</font>:본 시스템에서 연습문제들을 제출 할 수 있게 되었습니까? 가능하다면 당신이 사용하는 계정이 온라인 대회에 사용하게 될 계정이 됩니다. 다시 말해서, 그 계정을 이용하여 대회에 참가하면 됩니다.
만약 참가 할 수 없다면, <a href=registerpage.php>register</a> 메뉴에서 계정을 생성하세요.<br>
<br>
<hr>
<center>
  <font color=green size="+2">질문이나 제안은 <a href="http://zjicmacm.5d6d.com">ZJICM ACM BBS</a>에 해주시길 바랍니다.</font>
</center>
<hr>
<center>
  <table width=100% border=0>
    <tr>
      <td align=right width=65%><a href = "index.php"><font color=red><?php echo $OJ_NAME?></font></a> <a href = ""><font color=red>V1.9.9.0</font></a></td>
    </tr>
  </table>
</center>
<?php require_once('oj-footer.php');?>
