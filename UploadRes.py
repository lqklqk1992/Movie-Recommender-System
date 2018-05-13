import MySQLdb
import os

HOST="127.0.0.1"
USER="lqk"
PASSWD="cmsc5702"
DB="cmsc5702"

db = MySQLdb.connect(host=HOST,user=USER,passwd=PASSWD,db=DB)
cursor = db.cursor()
try:
	with open('res.txt','r') as f:
		for line in f:
			cursor.execute(line)
except MySQLdb.Error as e:
	print ("MySQL Error [%d]: %s" % (e.args[0], e.args[1]))
	exit()
finally:
	db.commit()
	db.close()