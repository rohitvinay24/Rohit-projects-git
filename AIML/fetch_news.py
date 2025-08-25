import sys
import requests
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.naive_bayes import MultinomialNB
import pandas as pd

# Load trained model
df = pd.read_csv("news_dataset.csv").dropna()
vectorizer = TfidfVectorizer()
X_train_vectorized = vectorizer.fit_transform(df["news_text"])
y_train = df["label"]
model = MultinomialNB().fit(X_train_vectorized, y_train)

# Fetch articles from NewsAPI
api_key = ""
query = sys.argv[1]
url = f"https://newsapi.org/v2/everything?q={query}&apiKey={api_key}"
response = requests.get(url).json()
articles = response.get("articles", [])

news_results = []

for article in articles[:5]:  # Limit results to 5 articles
    news_text = article["title"]
    X_test = vectorizer.transform([news_text])
    prediction = model.predict(X_test)
    news_results.append(f"{news_text} -> {'Fake' if prediction[0] == 0 else 'Real'}")

print("\n".join(news_results))

# pip install pandas scikit-learn requests