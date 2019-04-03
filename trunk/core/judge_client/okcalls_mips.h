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
int LANG_CV[256]={0,2,3,4,6,7,85,122,392,393,397,400,404,453,479,0};
//pascal
int LANG_PV[256] = {0,3,4,54,85,174,191,248,0};
//java
int LANG_JV[256]={0,263,273,282,2,3,5,32,36,50,60,70,74,77,87,97,82,85,88,92,94,104,122,127,148,152,177,182,192,202,208,230,240,250,272,320,337,347,357,382,392,393,395,396,397,400,401,402,403,404,405,406,409,419,429,412,430,447,479,338,348,358,6,16,26,64,73,398,407,416,420,451,0};
//ruby
int LANG_RV[256] = {0,0};
//bash
int LANG_BV[256]={0,3,4,5,6,19,20,33,45,54,63,64,65,78,122,125,140,174,175,183,191,192,195,197,199,200,201,202,221,248,0};
//python
int LANG_YV[256]={0,1,2,3,4,5,7,9,22,24,25,31,32,36,40,54,58,85,92,104,106,117,122,127,128,132,144,148,152,177,193,240,269,317,320,328,340,348,365,392,393,395,396,397,398,400,401,402,403,404,405,406,407,412,423,430,462,464,468,469,470,479,480,489,492,494,496,497,498,504,0};
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
