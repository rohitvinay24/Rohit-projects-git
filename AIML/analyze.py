import sys
import pandas as pd
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.naive_bayes import MultinomialNB

# Create a prebuilt CSV file with sample fake and real news data
csv_filename = "news_dataset.csv"

# Sample data for the CSV file
data = {
    "news_text": ["This is fake news", "This is true news", "Government bans social media", "NASA finds new planet"],
    "label": [0, 1, 0, 1]  # 0: Fake, 1: Real
}

# Save the sample data to a CSV file
df = pd.DataFrame(data)
df.to_csv(csv_filename, index=False)

# Load dataset from CSV file
df = pd.read_csv(csv_filename)  # Read the CSV file
df = df.dropna()  # Remove empty rows if any

# Train the model using TF-IDF and Naive Bayes
vectorizer = TfidfVectorizer()
X_train_vectorized = vectorizer.fit_transform(df["news_text"])
y_train = df["label"]

model = MultinomialNB()
model.fit(X_train_vectorized, y_train)

# Get user input
news_text = sys.argv[1]

# Predict authenticity
X_test = vectorizer.transform([news_text])
prediction = model.predict(X_test)

print("Fake News" if prediction[0] == 0 else "Real News")