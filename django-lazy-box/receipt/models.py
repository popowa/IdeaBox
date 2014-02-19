# -*- coding: utf-8 -*-

from django.db import models
from django.utils import simplejson as json
from urllib import urlopen
from django import forms
import math
# Create your models here.


FACEBOOK_URL = 'https://graph.facebook.com/'
JAPAN_TAX_RATE = 0.05
#JAPAN_TAX_EASY_NUM = 21

class FacebookPage:
    def __init__(self, url):
        self.page_name = url

    def __str__(self):
        return FACEBOOK_URL + self.page_name

    def url(self):
        return FACEBOOK_URL + self.page_name + u'/'

    def get_address(self):
        u = urlopen(str(self.url()))
        data = json.load(u)
        return data

class Payment:
    def __init__(self, amount):
        self.amount = int(amount)
    
    def __str__(self):
        return str('%s' % (self.amount))
    
    def original(self):
        return int(self.amount / (1+JAPAN_TAX_RATE))

    def tax(self):
        return int(round(self.amount - self.original()))

class ReceiptGenerateForm(forms.Form):
    company_postal = forms.CharField(label = u'Zip / 郵便番号', required=True)
    company_name = forms.CharField(label = u'Name / 会社名', required=True)
    company_address = forms.CharField(label = u'Address / 住所', required=True)
    company_tel = forms.CharField(label =u'Tel / 電話番号')
    company_url = forms.URLField(label = u'Website URL / ウェブサイトURL', required=False)
    company_logo = forms.URLField(label = u'Logo URL / ロゴURL', required=False)
    receipt_for = forms.CharField(label =u'Receipt For / 但し書き')
    receipt_number = forms.IntegerField(label=u'Receipt Number / 通し番号', required=True)
    receipt_customers = forms.FileField(label = u'Customers CSV / 宛名情報CSV', required=False)
    receipt_pay = forms.IntegerField(label=u'Amount / 領収金額', required=True)
