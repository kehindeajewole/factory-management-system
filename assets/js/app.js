
// tinymce.init({
//   selector: '.tinymce-edit',
//   menubar: false,
//   toolbar: true 
// });

// tinymce.init({
//   selector: '.tinymce-view',
//   menubar: false,
//   readonly: 1,
//   toolbar: false,  
//   content_style:
//     "body { color: #8898aa; }",
// });


async function dec_inc_qty(event) {
	if (event.target.className === "btn-inc-dec qty-btn-inc") {
		let currValue = event.target.previousElementSibling.value ;
		currValue++;
		event.target.previousElementSibling.value = currValue;
		let newqty = currValue;
		event.target.parentNode.dataset.qty = newqty;
		console.log(event.target.parentNode.dataset)
	} else if(event.target.className === "btn-inc-dec qty-btn-dec"){
		let currValue = event.target.nextElementSibling.value;
		if (currValue > 1) {
			currValue--;
			event.target.nextElementSibling.value = currValue;
			let newqty = currValue;
			event.target.parentNode.dataset.qty = newqty;
			console.log(event.target.parentNode.dataset)
		}
	} else if(event.target.className === "btn btn-fms btn-block mt-4"){
			event.preventDefault();
			console.log(event.target.previousElementSibling.dataset)

			let postData = new FormData();
			let postId = event.target.previousElementSibling.dataset.id;
			let postQty = event.target.previousElementSibling.dataset.qty;
			let postAmount = event.target.previousElementSibling.dataset.amount;
			let postName = event.target.previousElementSibling.dataset.name;
			postData.append("id", postId);
			postData.append("qty", postQty);
			postData.append("amount", postAmount);
			postData.append("name", postName);

			const response = await fetch(`../controllers/order-controllers.php?cartid=${postId}`, {
				method: "POST",
				body: postData
			});
			try {
				const newData = await response.json();
				console.log(newData)
				window.location.reload(true);
			} catch(error) {
				console.log("error", error);
			}
	}
}

let btnEvent = document.querySelector(".update-unit-qty-all");
btnEvent.addEventListener("click", dec_inc_qty);



