URL_String=input("Please enter your Twitter board url {https://www.twitter.com/username/media}: ")

from tkinter import filedialog
FOLDER_URL=filedialog.askdirectory(title="Select the folder where you want to save the images: ")
if FOLDER_URL=='':
    print('Folder not selected')
    exit(0)

from lxml import html
import requests

page=requests.get(URL_String)
print(page.status_code)
tree=html.fromstring(page.content)

print(tree)
tweet_imgs=tree.xpath('//div[@class="AdaptiveMedia-singlePhoto"]//img[@src]')

del page, tree

import requests, bs4
import urllib
print("Array of tweet images fetched")
print(tweet_imgs)
n = 1
for tweet_img in tweet_imgs:
    print("Tweet " + tweet_img.attrib['src'] + " processed")
    image_address=requests.get(tweet_img.attrib['src'])
    resource=image_address.content
    output=open(FOLDER_URL + "/" + "Image" + str(n) + ".jpg", "wb")
    output.write(resource)
    output.close()
    n=n+1