# Wikka REST API

[![Slim](https://raw.githubusercontent.com/pepitosoft/wikka-api/master/images/slimlogo.jpg)](https://www.slimframework.com/)
[![WikkaWiki](https://raw.githubusercontent.com/pepitosoft/wikka-api/master/images/wizard.gif)](http://wikkawiki.org/HomePage)

## What is this?

This is a PHP micro framework that implements Slim, helps you quickly write simple yet powerful web applications and APIs for WikkaWiki.

Easy step:

1. Put this repo on "3rdparty/plugins/slim" directory.
2. Edit the settings.php file.

## Why?

This implementation make posible to create APIs for WikkaWiki.
  - Make posible Rapid Prototyping.
  - Is a very powerfull interfase for multiple Wikkas.
  - Building an API is one of the most important things you can do to increase the value of your service.

## How?

A RESTful API has many way to access, the classic way is using the curl command:

1. Create a "token", from the WikkaUser:

### curl

For example, we want to create a token login with our Wikka user, the access to make query needs this token:

```bash
curl "http://172.17.0.2/wikka/3rdparty/plugins/slim/public/index.php/token" \
     --request POST       \
     --include            \
     --insecure           \
     --user WikkaUser:myWikkaPasswo \
     --header "Content-Type: application/json"
```

```json
HTTP/1.1 201 Created
Date: Wed, 11 Jan 2017 00:59:38 GMT
Server: Apache/2.4.18 (Ubuntu)
Set-Cookie: PHPSESSID=vl9s4m8eqqd3h4d7kna5ft5u50; path=/
Expires: Thu, 19 Nov 1981 08:52:00 GMT
Cache-Control: no-store, no-cache, must-revalidate
Pragma: no-cache
Content-Length: 188
Content-Type: application/json

{
    "status": "ok",
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE0ODQwOTYzNzgsImV4cCI6MTQ4NDEwMzU3OCwic3ViIjoiT2VNdW5veiJ9.dDduFQI-eqW8lmQvjylsTvpyAOA24k_fEVwaYx_b6oQ"
}
```

### HTTPie

or I prefer HTTPie for this

```bash
export TOKEN="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE0ODQwOTYzNzgsImV4cCI6MTQ4NDEwMzU3OCwic3ViIjoiT2VNdW5veiJ9.dDduFQI-eqW8lmQvjylsTvpyAOA24k_fEVwaYx_b6oQ"
http --auth-type=jwt --auth="$TOKEN:" http://172.17.0.2/wikka/3rdparty/plugins/slim/public/index.php/pages/tag/HomePage
```

```json
HTTP/1.1 200 OK
Cache-Control: no-store, no-cache, must-revalidate
Connection: Keep-Alive
Content-Encoding: gzip
Content-Length: 1331
Content-Type: text/html; charset=UTF-8
Date: Wed, 11 Jan 2017 01:05:26 GMT
Expires: Thu, 19 Nov 1981 08:52:00 GMT
Keep-Alive: timeout=5, max=100
Pragma: no-cache
Server: Apache/2.4.18 (Ubuntu)
Set-Cookie: PHPSESSID=rp66nndfgl4csan8v6tlfk38r7; path=/
Vary: Accept-Encoding

{
    "body": "e3tpbWFnZSB1cmw9ImltYWdlcy93aWtrYV9sb2dvLmpwZyIgYWx0PSJ3aWtrYSBsb2dvIiB0aXRsZT0iV2VsY29tZSB0byB5b3VyIFdpa2thIHNpdGUifX0tLS17e2NoZWNrdmVyc2lvbn19LS0tVGhhbmtzIGZvciBpbnN0YWxsaW5nIFdpa2thISBUaGlzIHdpa2kgcnVucyBvbiB2ZXJzaW9uICMje3t3aWtrYXZlcnNpb259fSMjLCBwYXRjaCBsZXZlbCAjI3t7d2lra2FwYXRjaGxldmVsfX0jIy4gWW91IG1heSB3YW50IHRvIHJlYWQgdGhlIFtbV2lra2FSZWxlYXNlTm90ZXMgfCByZWxlYXNlIG5vdGVzXV0gdG8gbGVhcm4gd2hhdCdzIG5ldyBpbiB0aGlzIHJlbGVhc2UuLS0tLS0tLS0te3tjb2xvciBjPSdyZWQnIHRleHQ9J05PVEU6IFRoaXMgdmVyc2lvbiBoYXMgcmVnaXN0cmF0aW9ucyBkaXNhYmxlZCBieSBkZWZhdWx0Lid9fSBZb3UgTVVTVCBlbmFibGUgdXNlciByZWdpc3RyYXRpb25zIGluICMjd2lra2EuY29uZmlnLnBocCMjICgjIydhbGxvd191c2VyX3JlZ2lzdHJhdGlvbicgPT4gJzEnLCMjKSB0byBhbGxvdyBhY2Nlc3MgYnkgdXNlcnMgb3RoZXIgdGhhbiB0aGUgYWRtaW5pc3RyYXRvciBzZXQgdXAgZHVyaW5nIGluc3RhbGxhdGlvbi4tLS0tLS0+Pj09S2VlcCB1cC10by1kYXRlPT1UbyByZWNlaXZlIHRoZSBsYXRlc3QgbmV3cyBmcm9tIHRoZSBXaWtrYSBEZXZlbG9wbWVudCBUZWFtLCB5b3UgY2FuIHNpZ24gdXAgdG8gb25lIG9mIG91ciBbW2h0dHA6Ly93aWtrYXdpa2kub3JnL1dpa2thTWFpbGluZ0xpc3RzIHwgbWFpbGluZyBsaXN0c11dLCBzdWJzY3JpYmUgdG8gb3VyIFtbaHR0cDovL2Jsb2cud2lra2F3aWtpLm9yZyB8IEJsb2ddXSBvciBqb2luIHVzIGZvciBhIGNoYXQgb24gW1todHRwOi8vd2lra2F3aWtpLm9yZy9UaGVMb3VuZ2UgfCBJUkNdXS4tLS0+Pj09PT1HZXR0aW5nIHN0YXJ0ZWQ9PT09RG91YmxlLWNsaWNrIG9uIHRoaXMgcGFnZSBvciBjbGljayBvbiB0aGUgKipFZGl0KiogbGluayBpbiB0aGUgcGFnZSBmb290ZXIgdG8gZ2V0IHN0YXJ0ZWQuIElmIHlvdSBhcmUgbm90IHN1cmUgaG93IGEgd2lraSB3b3JrcywgeW91IGNhbiBjaGVjayBvdXQgdGhlIFtbRm9ybWF0dGluZ1J1bGVzIHwgV2lra2EgZm9ybWF0dGluZyBndWlkZV1dIGFuZCBwbGF5IGluIHRoZSBTYW5kQm94Li0tLS0tLT4+PT1OZWVkIG1vcmUgaGVscD89PURvbid0IGZvcmdldCB0byB2aXNpdCB0aGUgW1todHRwOi8vd2lra2F3aWtpLm9yZyB8IFdpa2thV2lraSB3ZWJzaXRlXV0hPj49PT09U29tZSB1c2VmdWwgcGFnZXM9PT09Cn4tW1tGb3JtYXR0aW5nUnVsZXMgfCBXaWtrYSBmb3JtYXR0aW5nIGd1aWRlXV0Kfi1bW1dpa2thRG9jdW1lbnRhdGlvbiB8IERvY3VtZW50YXRpb25dXQp+LVtbUmVjZW50Q2hhbmdlcyB8IFJlY2VudGx5IG1vZGlmaWVkIHBhZ2VzXV0Kfi1bW1N5c0luZm8gfCBTeXN0ZW0gSW5mb3JtYXRpb25dXQotLS1Zb3Ugd2lsbCBmaW5kIG1vcmUgdXNlZnVsIHBhZ2VzIGluIHRoZSBbW0NhdGVnb3J5V2lraSB8IFdpa2kgY2F0ZWdvcnldXSBvciBpbiB0aGUgUGFnZUluZGV4Li0tLQ==",
    "id": "1",
    "latest": "Y",
    "note": "",
    "owner": "OeMunoz",
    "tag": "HomePage",
    "time": "11:09:20",
    "title": "",
    "user": "WikkaInstaller"
}

```

```bash
http --auth-type=jwt --auth="$TOKEN:" http://172.17.0.2/wikka/3rdparty/plugins/slim/public/index.php/pages/tag/HomePage | jshon | grep body | awk -F "\"" '{print($4)}' | base64 -d
```

```wiki
{{image url="images/wikka_logo.jpg" alt="wikka logo" title="Welcome to your Wikka site"}}---{{checkversion}}---Thanks for installing Wikka! This wiki runs on version ##{{wikkaversion}}##, patch level ##{{wikkapatchlevel}}##. You may want to read the [[WikkaReleaseNotes | release notes]] to learn what's new in this release.---------{{color c='red' text='NOTE: This version has registrations disabled by default.'}} You MUST enable user registrations in ##wikka.config.php## (##'allow_user_registration' => '1',##) to allow access by users other than the administrator set up during installation.------>>==Keep up-to-date==To receive the latest news from the Wikka Development Team, you can sign up to one of our [[http://wikkawiki.org/WikkaMailingLists | mailing lists]], subscribe to our [[http://blog.wikkawiki.org | Blog]] or join us for a chat on [[http://wikkawiki.org/TheLounge | IRC]].--->>====Getting started====Double-click on this page or click on the **Edit** link in the page footer to get started. If you are not sure how a wiki works, you can check out the [[FormattingRules | Wikka formatting guide]] and play in the SandBox.------>>==Need more help?==Don't forget to visit the [[http://wikkawiki.org | WikkaWiki website]]!>>====Some useful pages====
~-[[FormattingRules | Wikka formatting guide]]
~-[[WikkaDocumentation | Documentation]]
~-[[RecentChanges | Recently modified pages]]
~-[[SysInfo | System Information]]
---You will find more useful pages in the [[CategoryWiki | Wiki category]] or in the PageIndex.---
```

### Guzzle action

Guzzle-wikka is a plugin build on guzzle, for access other APIs (include Wikka-Api)

[![Guzzle](https://raw.githubusercontent.com/pepitosoft/wikka-api/master/images/GuzzleAction.png)](http://docs.guzzlephp.org/en/latest/)

[![Guzzle](https://raw.githubusercontent.com/pepitosoft/wikka-api/master/images/GuzzleActionRender.png)](http://docs.guzzlephp.org/en/latest/)

### How install it?

#### Install the action:

This is a parallel aplication, use the data but is independient from the actual system:

Drop this repo on your "3rdparty/plugins/slim" directory.

Directory Estructure:

```bash
cd 3rdparty/plugins
mkdir slim
git clone https://github.com/pepitosoft/wikka-api.git slim/
```

## FAQs and TODOs

- Is part of the default plugins of WikkaWiki

> R: For now, is not, This is a bigger implementation, Im not sure where is the right place to this.

- [ ] TODO: Add information from the original README.md
- [ ] TODO: Chosse a correct path on the WikkaWiki estructure.
- [ ] TODO: Implement this over the https port.
- [ ] TODO: Read the configuration from the wikka.config.php.
- [ ] TODO: Versions for the API access. (v1, v2, etc.)
- [x] TODO: Create a temporal token (two hours) usning the user and password from the wikka database.
- [x] TODO: The content of each page must be exported using base64, this make posible avoid stranger charsets.
- [x] TODO: Loggin activity.
- [x] TODO: Support Mysql/sqlite.

# Powered by:
- [Slim](https://www.slimframework.com/) Slim is a PHP micro framework that helps you quickly write simple yet powerful web applications and APIs.
- [WikkaWiki](http://wikkawiki.org/HomePage) is a flexible, standards-compliant and lightweight wiki engine written in PHP, which uses MySQL to store pages.
- [tuupola/slim-jwt-auth](https://github.com/tuupola/slim-jwt-auth) PSR-7 JWT Authentication Middleware.
- [Guzzle](http://docs.guzzlephp.org/en/latest/)

# References:
- [PSR-7 JSON Web Token Authentication Middleware](https://www.appelsiini.net/projects/slim-jwt-auth)
