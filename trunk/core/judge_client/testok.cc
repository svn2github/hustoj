#include "okcalls.h"
#include <stdio.h>

int main(){
	int i;
	printf("JAVA\n");
	for (i=0;LANG_JV[i];i++) printf("%d %d\n",LANG_JV[i],LANG_JC[i]);
	printf("C\n");
	for (i=0;LANG_CV[i];i++) printf("%d %d\n",LANG_CV[i],LANG_CC[i]);
	printf("Pascal\n");
	for (i=0;LANG_PV[i];i++) printf("%d %d\n",LANG_PV[i],LANG_PC[i]);
	return 0;
}

