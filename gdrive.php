<!DOCTYPE html>
<html>
<body>
	<div id="board" data-status="start">
		<h3 class="notification"></h3>
		<label>Code(Optional): <input type="text" id="code" name="code"/></label>
		<label>FileID: <input type="text" id="file" name="file"/></label>
		<label>Email: <input type="email" id="email" name="email"/></label>
		<button class="button submit-btn">
			<span class="next-text">Submit</span>
			<i class="fa fa-angle-double-right"></i>
		</button>
		<div class="description"></div>
	</div>
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script type="text/javascript">
		$( function() {
			$( ".submit-btn").click(function(e) {
				var code = $("#code").val();
				var file = $("#file").val();
				var email = $("#email").val();
				$.ajax({ url: 'ctrl.php', data: {action: 'insertPermission', code: code, file: file, email: email},
					type: 'post',
					dataType: 'json',
					success: function(output) {
						if(output.status == '0') {
							$(".notification").text("Create Code!");
							$(".description").html(output.html);
						} else if(output.status == '1') {
							$(".notification").text("An Exception Occured");
							$(".description").html(output.html);
						} else {
							$(".notification").text("Success!!!");
							$(".description").html(output.html);
						}
					}
				});
			});
		});
	</script>
</body>
</html>