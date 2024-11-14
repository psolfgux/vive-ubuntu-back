@php
$containerFooter = ($configData['contentLayout'] === 'compact') ? 'container-xxl' : 'container-fluid';
@endphp

<!-- Footer -->
<footer class="content-footer footer bg-footer-theme">
  <div class="{{ $containerFooter }}">
    <div class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
      <div class="text-body mb-2 mb-md-0">
        © <script>document.write(new Date().getFullYear())</script>,
        Desarrollado por 
        <a href="https://gux.tech/" target="_blank">GUX Technologie</a>
      </div>
      
    </div>
  </div>
</footer>
<!--/ Footer -->
