#!/bin/bash
set -vx

myfunc() {

	echo "Using functions"

}

total=1

while [ $total -le 3 ]; do

	myfunc

	total=$(($total + 1))

done

echo "Loop finished"

myfunc

myaddfunc() {

	read -p "Enter a value: " value

	echo $(($value + 10))

}

result=$(myaddfunc)

echo "The value is $result"

echo "End of the script"