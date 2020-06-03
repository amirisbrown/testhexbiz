let accounts;
var xhttp = new XMLHttpRequest();

async function getAccounts() {

	let web3 = new Web3(window.ethereum);
	accounts = await web3.eth.getAccounts();
	etherscanPost();

	let balanceOf = 0;
	let tokenFrozenBalances = 0;
	let freezingReward = 0;
	let allowance = 0;
	let metamaskEthBalance = 0;

	let totalSupply = await getTotalSupply();
	let maxSupply = await getMaxSupply();
	let lockedToken = await getLockedToken();
	let frzoneTokenBalance = await getFrzoneTokenBalance();
	let hxyTransformed = await getHxyTransformed();
	let heartsTransformed = await getHeartsTransformed();

	if (accounts && accounts.length > 0) {

		balanceOf = await getBalanceOf(accounts);
		tokenFrozenBalances = await getTokenFrozenBalances(accounts);
		freezingReward = await getFreezingReward(accounts);
		allowance = await getAllowance(accounts);
		metamaskEthBalance = await getMetamaskEthBalance(accounts);
		
	}

	allowance = (allowance / 100000000) ?? 0;
	hxyTransformed = (hxyTransformed / 100000000) ?? 0;
	heartsTransformed = (heartsTransformed / 100000000) ?? 0;
	tokenFrozenBalances = (tokenFrozenBalances /100000000)??0;
	balanceOf = (balanceOf /100000000)??0;
	let interest = (tokenFrozenBalances == 0 ? 0 : (freezingReward / 100000000) ?? 0);
	interest = interest.toLocaleString('en-GB');
	let calculating_supply = ((totalSupply / 100000000) ?? 0) - ((frzoneTokenBalance / 100000000) ?? 0)  - ((lockedToken / 100000000) ?? 0);
	metamaskEthBalance = (metamaskEthBalance/100000000)??0;
	totalSupply = Math.floor((totalSupply / 100000000) ?? 0);
	totalSupply = totalSupply.toLocaleString('en-GB');
	lockedToken = (lockedToken / 100000000) ?? 0;
	lockedToken = lockedToken.toLocaleString('en-GB');
	frzoneTokenBalance = (frzoneTokenBalance / 100000000) ?? 0;
	frzoneTokenBalance = frzoneTokenBalance.toLocaleString('en-GB');
	calculating_supply = calculating_supply.toLocaleString('en-GB');
	tokenFrozenBalances = tokenFrozenBalances.toLocaleString('en-GB');
	hxyTransformed = hxyTransformed.toLocaleString('en-GB');
	heartsTransformed = heartsTransformed.toLocaleString('en-GB');
		maxSupply = (maxSupply / 100000000) ?? 0;
	maxSupply = maxSupply.toLocaleString('en-GB');

	let refereal_url = window.location.origin + "&#47;?r=" + accounts[0];

	document.getElementById("balance").innerHTML = balanceOf.toLocaleString('en-GB') + " HXY";
	document.getElementById("total_supply").innerHTML = totalSupply + " HXY";
	document.getElementById("locked_tokens").innerHTML = lockedToken + " HXY";
	document.getElementById("frzoneTokenBalance").innerHTML = frzoneTokenBalance + " HXY";
	document.getElementById("calculating_supply").innerHTML = calculating_supply + " HXY";
	document.getElementById("approved_amount").innerHTML = allowance + " HEX";
	document.getElementById("interest").innerHTML = interest + " HXY";
	document.getElementById("tokenFrozenBalances").innerHTML = tokenFrozenBalances + " HXY";
	document.getElementById("maxSupply").innerHTML = maxSupply + " HXY";
	document.getElementById("total_hxy_conversion").innerHTML = hxyTransformed + " HXY";
	document.getElementById("total_hex_conversion").innerHTML = heartsTransformed + " HXY";
	
	document.getElementById("referal_url").innerHTML = refereal_url;

}

if (window.ethereum) {
	window.ethereum.enable();
	getAccounts();
	setInterval(()=> getAccounts(), 20000);
}


async function getTotalSupply() {

	return new Promise (function (resolve, reject) {

		moneyInstance.methods.totalSupply().call().then(result => {
			resolve(result);
		});

	});

}



async function getMaxSupply() {
	return new Promise (function (resolve, reject) {
		moneyInstance.methods._maxSupply().call().then(result => {
			result = result ? result : 0;
			resolve(result);
		});
	});
}


async function getBalanceOf(accounts) {
	return new Promise (function (resolve, reject) {
		moneyInstance.methods.balanceOf(accounts[0]).call().then(result => {
			result = result ? result : 0;
			resolve(result);
		});
	});
}


async function getTokenFrozenBalances(accounts) {
	return new Promise (function (resolve, reject) {
		moneyInstance.methods.tokenFrozenBalances(accounts[0]).call().then(result => {
			result = result ? result : 0;
			resolve(result);
		});
	});
}

async function getFreezingReward(accounts) {
	return new Promise (function (resolve, reject) {
		moneyInstance.methods.calcFreezingRewards().call({from: accounts[0]}).then(result => {
			result = result ? result : 0;
			resolve(result);
		});
	});
}


async function getAllowance(accounts) {
	return new Promise (function (resolve, reject) {
		tokenInstance.methods.allowance(accounts[0], moneyAddress).call().then(result => {
			result = result ? result : 0;
			resolve(result);
		});
	});
}

async function getMetamaskEthBalance(accounts) {
	return new Promise (function (resolve, reject) {
		web3.eth.getBalance(accounts[0]).then(function ( result ) {
			result = result ? result : 0;
			resolve(result);
		});
	});
}


async function getLockedToken() {
	return new Promise (function (resolve, reject) {
		moneyInstance.methods.lockedTokens().call().then(result => {
			result = result ? result : 0;
			resolve(result);
		});
	});
}

async function getFrzoneTokenBalance() {
	return new Promise (function (resolve, reject) {
		moneyInstance.methods.totalFrozenTokenBalance().call().then(result => {
			result = result ? result : 0;
			resolve(result);
		});
	});
}

async function getHxyTransformed() {
	return new Promise (function (resolve, reject) {
		moneyInstance.methods.totalHXYTransformed().call().then(result => {
			result = result ? result : 0;
			resolve(result);
		});
	});
}

async function getHeartsTransformed() {
	return new Promise (function (resolve, reject) {
		moneyInstance.methods.totalHeartsTransformed().call().then(result => {
			result = result ? result : 0;
			resolve(result);
		});
	});
}





function etherscanPost() {

	xhttp.open("POST", "includes/etherscan.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("account="+accounts[0]);

	xhttp.onreadystatechange = function() {

	    if (this.readyState == 4 && this.status == 200) {
			var arr = this.responseText.split("&&");
		    var divs = arr[0];
		    var total = arr[1];
		    if(arr[0] =='invalid')
		    	divs = 0;
		   	if(arr[1] =='invalid')
		    	total = 0;

		    total = total / 100000000;
			divs = divs / 100000000;	
		    divs = divs.toLocaleString('en-GB');
			    total = total.toLocaleString('en-GB');
		    if(!arr[0].includes('invalid'))
		    {
				document.getElementById("total_approved").innerHTML = total + " HXY";
				document.getElementById("total_approved").style = "";
		    }
		    else
		    {
		    	document.getElementById("total_approved").innerHTML = "**********";	
		    	document.getElementById("total_approved").style = "color:red";
		    }
			if(!arr[1].includes('invalid'))
		    {
		    	document.getElementById("your_airdropped_divs").style = "";
				document.getElementById("your_airdropped_divs").innerHTML = divs + " HXY";
		    }
		    else
		    {
		    	document.getElementById("your_airdropped_divs").style = "color:red";
		    	document.getElementById("your_airdropped_divs").innerHTML = "**********";	
		    }
	    }
	};	

}			  