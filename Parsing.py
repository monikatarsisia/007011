from BeautifulSoup import BeautifulSoup
import urllib2

thisurl = "http://bisniskeuangan.kompas.com/"
handle = urllib2.urlopen(thisurl)
html_doc =  handle.read()
handle.close()

target = open("dataOri.html", 'w')
target.write(html_doc)
target.close()

soup = BeautifulSoup(html_doc)

savelink = open("hyperlink.html", 'w')

data = 1

for link in soup.findAll('a'):
	anotherlink =link.get('href')
	
	handlelink = urllib2.urlopen(anotherlink)
	html_doclink = handlelink.read()
	nameoffile = "data" + str(data) + ".html"
	targetlink = open(nameoffile, 'w')
	targetlink.write(html_doclink)
	targetlink.close()
	
	savelink.write(anotherlink)
	savelink.write("\n")
	print(anotherlink)
	handlelink.close()
	
	data = data + 1

savelink.close()
