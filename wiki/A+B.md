 C语言:
--

```c
#include <stdio.h>
int main(){
    int a,b;
    while(scanf("%d %d",&a, &b) != EOF)
        printf("%d\n",a+b);
	return 0;
}

```
------------------------------
 C++语言
--
```c++	
#include <iostream>
using namespace std;
int main(){
    int a,b;
    while(cin >> a >> b)
        cout << a+b << endl;
	return 0;
}
```
------------------------------
Java语言
--
```java
import java.util.*;
public class Main{
	public static void main(String args[]){
		Scanner cin = new Scanner(System.in);
		int a, b;
		while (cin.hasNext()){
			a = cin.nextInt(); b = cin.nextInt();
			System.out.println(a + b);
		}
	}
}
```
------------------------------
Ruby语言
--
```ruby
a=gets
while a != nil && a != "" && a != "\r" && a != "\n" do
	arr = a.split(" ")
	sum = 0
	arr.each_with_index do |value, index|
		sum = sum + value.to_i
	end
	puts sum.to_s
	a=gets
end
```
------------------------------
Bash语言
--
```bash		 
#!/bin/bash

read -a arr
#echo ${#arr[@]}
while [ ${#arr[@]} -eq 2 ]
do
sum=$((${arr[0]}+${arr[1]}))
echo "$sum"
read -a arr
done
```
------------------------------
Python语言
--
```python
#!/usr/bin/env python  
# coding=utf-8  
  
a=[]  
  
for x in raw_input().split():  
    a.append(int(x))  
  
print sum(a)
```
------------------------------
PHP语言
--
```php
<?php
function solveMeFirst($a,$b){
    return $a + $b;
}
$handle = fopen ("php://stdin","r");
$a = explode(" ",fgets($handle));
$sum = solveMeFirst((int)$a[0],(int)$a[1]);
print ($sum);
fclose($handle);
?>
```
------------------------------
Perl语言
--
```perl
while (<>) {($a, $b) = split; print $a+$b,"\n" }
```
------------------------------
C#语言
--
```c#
using System;

namespace myApp
{
    class Program
    {
        public static void Main()
        {
            string line;
            
            while (!string.IsNullOrEmpty(line = Console.ReadLine()))
            {
                string[] p = line.Split(' ');
                int n = int.Parse(p[0]);
                int m = int.Parse(p[1]);
                int sum = m + n;
                   
                Console.WriteLine(sum.ToString());
            }
        }
    }
}
```
------------------------------
Obj-C语言
--
```obj-c
#include <stdio.h>
int main(){
    int a,b;
    while(scanf("%d %d",&a, &b) != EOF)
        printf("%d\n",a+b);
	return 0;
}
```
------------------------------
FreeBasic语言
--
```freebasic
dim a.b
open "data.in" for input as #1
while not eof(1)
 input #1, a,b
 print ""&(a+b)
wend
```
------------------------------
Schema语言
--
```schema
(define a (read))
(define b (read))
(write (+ a b))
(newline)
(exit 0)
```
------------------------------
Clang编译器的C语言
--
```c
#include <stdio.h>
int main(){
    int a,b;
    while(scanf("%d %d",&a, &b) != EOF)
        printf("%d\n",a+b);
	return 0;
}
```
------------------------------
Clang++编译器的C++语言
--
```c++
#include <iostream>
using namespace std;
int main(){
    int a,b;
    while(cin >> a >> b)
        cout << a+b << endl;
	return 0;
}

```
------------------------------
Lua语言
--
```lua
local count = 0
function string.split(str, delimiter)
	if str==nil or str=='' or delimiter==nil then
		return nil
	end
	
    local result = {}
    for match in (str..delimiter):gmatch("(.-)"..delimiter) do
        table.insert(result, match)
    end
    return result
end
while true do
	local line = io.read()
	if line == nil or line == "" then break end
	local tb = string.split(line, " ")
	local sum = 0
	for i=1, #tb do
		
		local a = tonumber(tb[i])
		sum = sum+a
	end
	if count>0 then
		io.write("\n")
	end
	io.write(string.format("%d", sum))
	count = count+1
end
```
------------------------------
Go语言
--
```go
package main
import "fmt"
func main() {
  a:=0
  b:=0
  fmt.Scanf("%d%d",&a,&b);
  fmt.Printf("%d\n",a+b)
}
```
------------------------------
JavaScript 语言
--
```javascript
var line;
while ((line = readline()) != '') {
	//print(line);
	var arr = line.split(' ');
	var sum = 0;
	for (var i=0; i<arr.length; i++) {
		var a = parseInt(arr[i]);
		if (!isNaN(a))
			sum += a;
	}
	print(sum.toString());
}

```
------------------------------
nodejs语言
--
```javascript
var stdinstr = ""
process.stdin.setEncoding("utf8")

process.stdin.on('data', function(chunk) {
	//stdinstr += chunk.toString()
	//console.log(chunk.charCodeAt(0));
	if (chunk == undefined || chunk == null || chunk == '' || chunk.indexOf(' ') == -1)
		process.exit();
	else {
		var arr = chunk.split(' ');
		var a = parseInt(arr[0]);
		var b = parseInt(arr[1]);
		console.log(a + b);
	}
});
```
------------------------------
