# -*- coding: utf-8 -*-
# Create your views here.

from django.http import HttpResponse, HttpResponseRedirect, QueryDict, HttpResponseServerError
from django.core.context_processors import csrf
from django.shortcuts import render_to_response
from django.views.decorators.csrf import csrf_protect
from django.utils import simplejson
from django.template import RequestContext
from django.conf import settings

from django_project.receipt.models import FacebookPage, ReceiptGenerateForm, Payment

import datetime
import csv
#from reportlab.pdfgen import canvas



def receipt_index(request):
    generate_form = ReceiptGenerateForm()
    c = RequestContext(request, {'generate_form': generate_form})
    return render_to_response('index.html', c)


def receipt_list(request):
    if request.method == 'POST':
        form = ReceiptGenerateForm(request.POST)
        if form.is_valid():
            user_info = []
            f =  request.FILES['receipt_customers']
            rows = csv.reader(f, delimiter=',')
            for number, row in enumerate(rows):
                if 'company' in row:
                    pass
                else:
                    user_info.append({'number':number, 'company': row[0], 'name': row[1]})
            pay = Payment(form.cleaned_data['receipt_pay'])
            invoice = {
                'for': form.cleaned_data['receipt_for'],
                'number': form.cleaned_data['receipt_number'],
                'pay': pay,
                'price_original' : pay.original(),
                'price_tax': pay.tax()
                }
            company = {
                'postal': form.cleaned_data['company_postal'],
                'name' : form.cleaned_data['company_name'],
                'address': form.cleaned_data['company_address'],
                'tel': form.cleaned_data['company_tel'],
                'url' : form.cleaned_data['company_url'],
                }
            receipts = [0,1]
            c = RequestContext(request, {'user_info': user_info,'invoice': invoice, 'company': company, 'receipts': receipts })
            return render_to_response('list.html', c)
        else:
            generate_form = InvoiceGenerateForm()
            c = RequestContext(request, {'generate_form': generate_form})
            return render_to_response('index.html', c)


def receipt_facebook_page(request, url):
    to_return = {'error':u'No POST data sent.' }
    if not url:
        return HttpResponseServerError(simplejson.dumps(to_return), mimetype="application/json")
    facebook_page = FacebookPage(url)
    address = facebook_page.get_address()
    print address
    if address.get('error'):
        return HttpResponseServerError(address['error']['message'], mimetype="application/json")
    else:
        return HttpResponse(simplejson.dumps(address), mimetype="application/json")
        
def receipt_print_pdf(request):
    # 適切な PDF 用応答ヘッダを持った HttpResponse オブジェクトを
    # 作成します。
    response = HttpResponse(mimetype='application/pdf')
    response['Content-Disposition'] = 'attachment; filename=somefilename.pdf'

    # レスポンスオブジェクトを出力「ファイル」にして、 PDF オブジェクト
    # を作成します。
    p = canvas.Canvas(response)

    # PDF に描画します。 PDF 生成のキモの部分です。
    # ReportLab の詳しい機能は ReportLab ドキュメントを参照してください。
    p.drawString(100, 100, "Hello world.")

    # PDF オブジェクトをきちんと閉じて終わり。
    p.showPage()
    p.save()
    return response      
        
        