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
int LANG_CV[256]={0,3,4,5,33,45,85,122,192,197,248,0};
//pascal
int LANG_PV[256] = {0,3,4,54,85,174,191,248,0};
//java
int LANG_JV[256] ={0,2,3,5,6,19,33,45,85,91,120,122,125,174,175,191,192,195,197,240,248,256,338,0};
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
//sqlite3
int LANG_SQLV[256]={0,0};
