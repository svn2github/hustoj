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
int LANG_CV[256]={0,2,4,26,119,150,187,208,419,420,421,461,506,200,2,3,4,5,7,26,85,119,122,150,168,187,200,352,392,393,397,404,412,419,420,453,461,479,506,0};


//pascal
int LANG_PV[256] = {0,3,4,54,85,174,191,248,0};
//java
int LANG_JV[256]={0,2,3,10,24,26,29,32,40,89,98,99,117,119,142,150,156,168,187,191,192,195,213,232,248,419,421,422,427,435,440,449,461,463,465,466,492,501,506,507,320,164,8,364,208,52,406,250,94,450,293,137,493,337,181,25,372,18,222,376,68,426,272,2,3,10,24,26,29,32,40,89,98,99,117,118,119,142,150,156,168,187,192,195,213,232,243,244,248,419,421,422,427,435,440,449,461,463,465,466,492,501,506,507,2,3,10,24,26,29,32,40,82,89,98,99,117,119,142,150,156,168,187,192,195,213,232,248,383,391,392,419,421,422,427,435,440,449,461,463,465,466,492,501,506,507,0};
//ruby
int LANG_RV[256] = {0,0};
//bash
int LANG_BV[256]={0,3,4,5,6,19,20,33,45,54,63,64,65,78,122,125,140,174,175,183,191,192,195,197,199,200,201,202,221,248,0};
//python
int LANG_YV[256] = {0,3,4,5,6,19,33,41,45,54,85,91,122,125,140,174,175,183,186,191,192,195,196,197,199,200,201,202,217,221,240,248,256,322,338,0};
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
