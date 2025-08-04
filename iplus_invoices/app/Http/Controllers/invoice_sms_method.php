    public function sendSignSms(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);
        
        if (!$invoice->phone_number) {
            return back()->with('error', 'ნომერი არ არის მითითებული!');
        }

        $url = url("/sign/invoice/{$invoice->uuid}");
        $message = "თქვენი ინვოისი: $url";
        
        $sms = new SmsService();
        $response = $sms->send($invoice->phone_number, $message, $invoice->id);
        
        if (($response['status'] ?? '') === 'sent') {
            return back()->with('success', 'SMS წარმატებით გაიგზავნა!');
        }
        
        return back()->with('error', 'SMS გაგზავნა ვერ მოხერხდა!');
    }
