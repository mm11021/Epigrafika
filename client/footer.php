	
	<footer class="footer">
            <p class="text-center" style="padding: 15px; margin: 50px;"> Developed by MATF 2015 </p>
	</footer>
	<script type="text/javascript">
		var x = document.getElementsByTagName("*");
		for(var i=0;i<x.length;i++)
		{
			if(x[i].tagName!="IMG")
			x[i].addEventListener("focus",function() { poslednjiFokusiran = document.activeElement; });
		}
		</script>
	</body>
</html>