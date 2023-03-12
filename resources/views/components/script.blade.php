<script type="text/javascript">
	function sentConnect(user_id) {
		
		var userId = user_id;
		console.log($("#connection_row_hide_"+user_id).hide());
		$.ajax({
			url : '{{url('/sent_connection')}}',
			type : "get",
			data : {userId : userId},
		})
	}
	const getSentRequest = ()=>{

		$("#suggestion_toggle").attr('class','d-none')
		$("#request_toggle").attr('class','')
		$("#connection_toggle").attr('class','d-none')
		$("#skeleton_toggle_request").attr('class','');

		$.ajax({
			url : "{{url('/sent_request')}}",
			type : "get",
			success:function(data)
			{	
				var htmlData = '';
				if(data['success']){
					for(i in data['success']){
						
						htmlData += '<div class="my-2 shadow text-white bg-dark p-1 " id="withdrawrequest_row_hide_'+data['success'][i].reciever_user.id+'">';
    					htmlData += '<div class="d-flex justify-content-between">';
      					htmlData += '<table class="ms-1"><td class="align-middle">'+data['success'][i].reciever_user.name+'</td><td class="align-middle"> - </td><td class="align-middle">'+data['success'][i].reciever_user.email+'</td><td class="align-middle"></table><div><button id="cancel_request_btn_" class="btn btn-danger me-1" onclick="withDrawConnect(`'+data['success'][i].reciever_user.id+'`)">Withdraw Request</button></div></div></div>';
      					
					}
					$("#skeleton_toggle_request").attr('class','d-none');
					$(".ajax-request-sent").html(htmlData);
					$(".ajax-request-sent").show();
				}
			}
		})
	}

	const getSuggestion = ()=>{
		$("#skeleton_toggle").attr('class','');
		$("#suggestion_toggle").attr('class','')
		$("#request_toggle").attr('class','d-none')
		$("#connection_toggle").attr('class','d-none');
		$(".ajax-suggestions").hide();
		$.ajax({
			url : "{{url('/get_suggestion')}}",
			type : "get",
			success:function(data)
			{	
				var htmlData = '';
				if(data['success']){
					for(i in data['success']){
						
						htmlData += '<div class="my-2 shadow  text-white bg-dark p-1 " id="connection_row_hide_'+data['success'][i].id+'"><div class="d-flex justify-content-between"><table class="ms-1"><td class="align-middle">'+data['success'][i].name+'</td><td class="align-middle"> - </td><td class="align-middle">'+data['success'][i].email+'</td><td class="align-middle"> </table><div><button id="create_request_btn_" class="btn btn-primary me-1" onclick="sentConnect(`'+data['success'][i].id+'`)">Connect</button></div></div></div>';
      					
					}
					$("#skeleton_toggle").attr('class','d-none');
					$(".ajax-suggestions").html(htmlData);
					$(".ajax-suggestions").show();
				}
			}
			})
	}
	//with draw connect
	const withDrawConnect = (reciever_user_id)=>{

		var reciever_user_id = reciever_user_id;
		$("#withdrawrequest_row_hide_"+reciever_user_id).hide()
		$.ajax({
			url : "{{url('withdraw_connect')}}",
			type : 'get',
			data : {reciever_user_id : reciever_user_id}
		})
	}
	//see all accept request
	const getRecieveRequest = ()=>{
		$("#skeleton_toggle_request").attr('class','');
		$("#suggestion_toggle").attr('class','d-none');
		$("#request_toggle").attr('class','');
		$("#connection_toggle").attr('class','d-none');
		$.ajax({
			url : "{{url('/recieve_request')}}",
			type : "get",
			success:function(data)
			{	
				var htmlData = '';
				if(data['success']){
					for(i in data['success']){
						
						htmlData += '<div class="my-2 shadow text-white bg-dark p-1 " id="recieverequest_row_hide_'+data['success'][i].sender_user.id+'">';
    					htmlData += '<div class="d-flex justify-content-between">';
      					htmlData += '<table class="ms-1"><td class="align-middle">'+data['success'][i].sender_user.name+'</td><td class="align-middle"> - </td><td class="align-middle">'+data['success'][i].sender_user.email+'</td><td class="align-middle"></table><div><button id="cancel_request_btn_" class="btn btn-primary me-1" onclick="acceptConnect(`'+data['success'][i].sender_user.id+'`)">Accept</button></div></div></div>';
      					
					}
					$("#skeleton_toggle_request").attr('class','d-none');
					$(".ajax-request-sent").html(htmlData);
					$(".ajax-request-sent").show();
				}
			}
		})
	}
	//accept connection
	const acceptConnect = (sender_user_id)=>{

		var sender_user_id = sender_user_id;
		$("#recieverequest_row_hide_"+sender_user_id).hide()
		$.ajax({
			url : "{{url('accept_connect')}}",
			type : 'get',
			data : {sender_user_id : sender_user_id}
		})
	}

	// get connection
	const getConneciton = ()=>{
		$("#skeleton_toggle_connection").attr('class','');
		$("#suggestion_toggle").attr('class','d-none');
		$("#request_toggle").attr('class','d-none');
		$("#connection_toggle").attr('class','');
		$.ajax({
			url : "{{url('/get_connection')}}",
			type : "get",
			success:function(data)
			{	
				var htmlData = '';
				if(data['success']){
					for(i in data['success']){
						
						htmlData += '<div class="my-2 shadow text-white bg-dark p-1" id="removeconnection_row_hide_'+data['success'][i].id+'"><div class="d-flex justify-content-between"><table class="ms-1"><td class="align-middle">'+data['success'][i].name+'</td><td class="align-middle"> - </td><td class="align-middle">'+data['success'][i].email+'</td><td class="align-middle"></table><div><button id="create_request_btn_" class="btn btn-danger me-1" onclick="removeConnect(`'+data['success'][i].id+'`)">Remove Connection</button></div></div></div>';
      					
					}
					$("#skeleton_toggle_connection").attr('class','d-none');
					$(".ajax-connection").html(htmlData);
					$(".ajax-connection").show();
				}
			}
		})
	}
	const removeConnect = (connection_id)=>{
		var connection_id = connection_id;
		$("#removeconnection_row_hide_"+connection_id).hide()
		$.ajax({
			url : "{{url('remove_connect')}}",
			type : 'get',
			data : {connection_id : connection_id}
		})
	}
</script>