import pandas as pd
import numpy as np

df = pd.read_csv('asancafe.csv', sep=',', low_memory=False, encoding='utf-8-sig')

df = df.loc[df['상권업종대분류명'] == '음식']

df = df[['상호명', '상권업종소분류명', '표준산업분류명', '행정동명', '위도', '경도']]

df = df.loc[(df['행정동명'] == '신창면')]

df.columns = ['name', 'cate_1', 'cate_2', 'dong', 'lon', 'lat']
df['cate_mix'] = df['cate_1'] + df['cate_2']
df['cate_mix'] = df['cate_mix'].str.replace("/", " ")

from sklearn.feature_extraction.text import CountVectorizer  # 피체 벡터화
from sklearn.metrics.pairwise import cosine_similarity  # 코사인 유사도

count_vect_category = CountVectorizer(min_df=0, ngram_range=(1,2))
place_category = count_vect_category.fit_transform(df['cate_mix']) 
place_simi_cate = cosine_similarity(place_category, place_category) 
place_simi_cate_sorted_ind = place_simi_cate.argsort()[:, ::-1]

print(df)