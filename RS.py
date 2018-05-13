from surprise import SVD
from surprise import SVDpp
from surprise import NMF
from surprise import KNNBasic
from surprise import KNNWithMeans
from surprise import SlopeOne
from surprise import CoClustering
from surprise import Reader
from surprise import Dataset
import pandas as pd
import numpy as np
import os
# path to dataset file
file_path = os.path.expanduser('ratings.csv')
reader = Reader(line_format='user item rating', sep=',',skip_lines=1)
data = Dataset.load_from_file(file_path, reader=reader)
trainset = data.build_full_trainset()

# We'll use the famous SVD algorithm.
algo = SVD()
algo.train(trainset)

print("Step3: Calculating the estimated ratings of unwatched movies and upload to DB...")
arr=np.zeros(trainset.n_items)
predictions=algo.test(trainset.build_testset())
for uid, iid, true_r, est, _ in predictions:
	iiid=trainset.to_inner_iid(iid)
	arr[iiid]=arr[iiid]+true_r

predictions=algo.test(trainset.build_anti_testset())

with open('res.txt','w') as file:

	for uid, iid, true_r, est, _ in predictions:
		line="INSERT INTO RATING (Uid,MLid,Est_R) VALUES (%s, %s, %s)" % (uid,iid,est)
		file.write(line)
		file.write('\n')
		iiid=trainset.to_inner_iid(iid)
		arr[iiid]=arr[iiid]+est

	arr=arr/trainset.n_users
	for i in range(len(arr)):
		line= "UPDATE MOVIE SET Rating = %f WHERE MLid = %s" % (arr[i],trainset.to_raw_iid(i))
		file.write(line)
		file.write('\n')