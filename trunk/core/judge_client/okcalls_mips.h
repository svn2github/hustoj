/*
 * 
 *
 * This file is part of HUSTOJ.
 *
 * HUSTOJ is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * HUSTOJ is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with HUSTOJ. if not, see <http://www.gnu.org/licenses/>.
 */
#include <sys/syscall.h>
#define HOJ_MAX_LIMIT -1
#define LANGV_LENGTH 256
//C C++
int LANG_CV[256]={0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,40,41,42,43,44,45,46,47,48,49,52,55,56,57,60,61,63,64,65,66,68,69,75,79,80,85,94,95,99,104,122,139,170,188,198,292,383,385,392,393,397,400,404,454,453,479,484,485,490,0};
//pascal
int LANG_PV[256] = {0,3,4,54,85,174,191,248,0};
//java
int LANG_JV[256]={0,160,169,365,375,481,491,251,241,98,108,263,273,282,2,3,5,32,36,50,60,70,74,77,87,97,82,85,88,92,94,104,122,127,148,152,177,182,192,202,208,230,240,250,272,320,337,347,357,382,392,393,395,396,397,400,401,402,403,404,405,406,409,419,429,412,430,447,479,338,348,358,6,16,26,64,73,398,407,416,420,451,0};
//ruby
int LANG_RV[256] = {0,0};
//bash
int LANG_BV[256]={0,3,4,5,6,19,20,33,45,54,63,64,65,78,122,125,140,174,175,183,191,192,195,197,199,200,201,202,221,248,0};
//python
int LANG_YV[256]={0,1,2,3,4,5,7,8,9,22,24,25,31,32,33,36,40,44,49,54,58,73,75,85,92,97,104,106,112,115,117,122,127,128,132,144,148,152,153,177,192,193,197,202,240,233,238,269,273,278,285,317,320,324,349,328,340,348,365,392,393,395,396,397,398,400,401,402,403,404,405,406,407,412,411,416,423,430,432,433,462,464,468,469,470,479,480,489,492,494,496,497,498,499,504,0};
//php
int LANG_PHV[256] = {0,0};
//perl
int LANG_PLV[256] = {0,0};
//c-sharp
int LANG_CSV[256]={0,3,5,6,19,33,45,122,125,174,175,191,192,195,197,256,338,0};
//objective-c
int LANG_OV[256] = {0,0};
//freebasic
int LANG_BASICV[256] = {0,0};
//scheme
int LANG_SV[256] = {0,0};
//lua
int LANG_LUAV[256]={0,0};
//nodejs
int LANG_JSV[256]={0,0};
//go-lang
int LANG_GOV[256]={0,0};
//sqlite3
int LANG_SQLV[256]={0,1,2,3,4,5,6,7,12,13,16,17,18,20,21,22,25,28,32,36,40,41,44,49,51,52,57,64,70,85,90,92,100,119,122,127,148,152,167,168,174,177,197,216,272,320,360,392,393,395,396,397,398,400,401,402,404,405,406,407,408,409,412,430,432,433,459,461,462,465,468,469,477,487,492,497,0};
