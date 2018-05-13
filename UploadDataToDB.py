import MySQLdb
import csv
import hashlib
import random
import os
import codecs

HOST="127.0.0.1"
USER="lqk"
PASSWD="cmsc5702"
DB="cmsc5702"

#randomly create passwd
def RandomPass(length):             
	ALPHABET = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"
	chars=[]
	for i in range(length):
		chars.append(random.choice(ALPHABET))
	return "".join(chars)

def main():
	#connect to MYSQL db
	db = MySQLdb.connect(host=HOST,user=USER,passwd=PASSWD,db=DB)
	cursor = db.cursor()

	#create MOVIE table
	cursor.execute("DROP TABLE IF EXISTS MOVIE")
	sql = """CREATE TABLE MOVIE (
			MLid INT NOT NULL,
			TMDBid INT,
			Title  VARCHAR(255),
			Genres  VARCHAR(255),
			Rating REAL, 
			PRIMARY KEY (MLid))"""
	cursor.execute(sql)

	#upload MOVIE data to db from movies.csv
	with open('movies.csv') as csvfile:
		readCSV = csv.reader(csvfile, delimiter=',')
		for row in readCSV:
			if row[0]=="movieId":
				continue
			insert_stmt = (
				"INSERT INTO MOVIE (MLid,Title,Genres) "
				"VALUES (%s, %s ,%s)"
			)
			data = (row[0].strip(),row[1].strip(),row[2].strip())
			cursor.execute(insert_stmt, data)

	#upload TMDBid data to db from links.csv
	with open('links.csv') as csvfile:
		readCSV = csv.reader(csvfile, delimiter=',')
		for row in readCSV:
			if row[0]=="movieId":
				continue
			if row[2]=="":
				continue
			sql = "UPDATE MOVIE SET TMDBid = %s WHERE MLid = %s" % (row[2],row[0])
			cursor.execute(sql)
					
	#create RATING table
	cursor.execute("DROP TABLE IF EXISTS RATING")
	sql = """CREATE TABLE RATING (
			Uid INT NOT NULL,
			MLid INT NOT NULL,
			True_R REAL,
			Est_R REAL)"""
	cursor.execute(sql)

	#upload RATING data to db from ratings.csv
	with open('ratings.csv') as csvfile:
		readCSV = csv.reader(csvfile, delimiter=',')
		for row in readCSV:
			if row[0]=="userId":
				continue
			insert_stmt = (
				"INSERT INTO RATING (Uid,MLid,True_R) "
				"VALUES (%s, %s, %s)"
			)
			data = (row[0].strip(),row[1].strip(),row[2].strip())
			cursor.execute(insert_stmt, data)
		USER_NUM=int(row[0])

	#create USER table
	cursor.execute("DROP TABLE IF EXISTS USER")
	sql = """CREATE TABLE USER (
			Uid INT NOT NULL,
			Username  VARCHAR(255),
			Salt VARCHAR(255),  
			Passwd VARCHAR(255),
			PRIMARY KEY (Uid))"""
	cursor.execute(sql)

	#upload USER data with Username = User+Uid and Passwd randomly created
	for i in range(1,USER_NUM+1):
		password = RandomPass(8)
		password_salt = codecs.encode(os.urandom(8), 'hex')
		hash = hashlib.sha1()
		hash.update(('%s%s' % (password_salt, password)).encode('utf-8'))
		password_hash = hash.hexdigest()
		insert_stmt = (
			"INSERT INTO USER (Uid,Username,Salt,Passwd) "
			"VALUES (%s, %s, %s, %s)"
		)
		data = (i,"User"+str(i),password_salt,password_hash)
		cursor.execute(insert_stmt, data)

	db.commit()
	db.close()

if __name__ == '__main__':
	main()