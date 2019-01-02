# check module selinux policy modules
checkmodule /home/judge/src/install/my-phpfpm.te -M -m -o my-phpfpm.mod
checkmodule /home/judge/src/install/my-ifconfig.te -M -m -o my-ifconfig.mod

# package policy modules
semodule_package -m my-phpfpm.mod -o my-phpfpm.pp
semodule_package -m my-ifconfig.mod -o my-ifconfig.pp

# install policy modules
semodule -i my-phpfpm.pp
semodule -i my-ifconfig.pp

# clean up
echo "clean up selinux module output files"
rm -rf my-phpfpm.mod my-phpfpm.pp
rm -rf my-ifconfig.mod my-ifconfig.pp