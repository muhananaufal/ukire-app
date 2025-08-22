<x-app-layout>
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 text-center">
      <h1 class="text-3xl font-bold text-gray-800 mb-4">Final Step: Payment</h1>
      <p class="text-gray-600 mb-8">Click the button below to complete your payment securely.</p>
      <button id="pay-button" class="bg-gray-800 text-white py-3 px-8 rounded-md text-lg hover:bg-gray-700">Pay Now</button>
  </div>

  @push('scripts')
  <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
  <script type="text/javascript">
      document.getElementById('pay-button').onclick = function(){
          snap.pay('{{ $snapToken }}', {
              onSuccess: function(result){
                  window.location.href = '{{ route("checkout.success", $order) }}'
              },
              onPending: function(result){
                  alert("waiting for your payment!"); console.log(result);
              },
              onError: function(result){
                  alert("payment failed!"); console.log(result);
              },
              onClose: function(){
                  alert('you closed the popup without completing the payment');
              }
          })
      };
  </script>
  @endpush
</x-app-layout>