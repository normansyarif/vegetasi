import numpy as np
from sklearn.model_selection import train_test_split
import pandas as pd
import json

# absolutePath = "C:/xampp/htdocs/laravel/public/pyproject/";
absolutePath = "/opt/lampp/htdocs/laravel/public/pyproject/";

arr = [];

dataset = pd.read_csv(absolutePath + 'train.csv') #membaca file data training Csv
X = dataset.iloc[:, [2,3,4]].values #pilih kolom atribut yg dipakai
y = dataset.iloc[:, 5].values #kolom class
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size = 0.25, random_state = 0)
from sklearn.preprocessing import StandardScaler
sc = StandardScaler()
X_train = sc.fit_transform(X_train)
X_test = sc.transform(X_test)
from sklearn.svm import SVC
classifier= SVC(kernel='linear', random_state=0, gamma=1, C=0.1)
classifier.fit(X_train, y_train)
y_pred = classifier.predict(X_test)
from sklearn.metrics import accuracy_score
acc = accuracy_score(y_test, y_pred)
from sklearn.metrics import classification_report
tabel = classification_report(y_test, y_pred)

arr.append(acc)
arr.append(tabel)
arr.append(None)
arr.append(None)

print(json.dumps(arr))
