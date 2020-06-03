let accounts;
var xhttp = new XMLHttpRequest();

async function getAccounts() {

	accounts = await web3.eth.getAccounts();

	etherscanPost();

	let balanceOf = 0;
	let tokenFrozenBalances = 0;
	let freezingReward = 0;
	let allowance = 0;

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
		
	}

	allowance = (allowance / 100000000) ?? 0;
	hxyTransformed = (hxyTransformed / 100000000) ?? 0;
	heartsTransformed = (heartsTransformed / 100000000) ?? 0;
	tokenFrozenBalances = (tokenFrozenBalances /100000000)??0;
	balanceOf = (balanceOf /100000000)??0;
	let interest = (tokenFrozenBalances === 0 ? 0 : (freezingReward / 100000000) ?? 0);
	interest = interest.toLocaleString('en-GB');
	let calculating_supply = ((totalSupply / 100000000) ?? 0) - ((frzoneTokenBalance / 100000000) ?? 0)  - ((lockedToken / 100000000) ?? 0);
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

	return new Promise (function (resolve) {

		moneyInstance.methods.totalSupply().call().then(result => {
			resolve(result);
		});

	});

}



async function getMaxSupply() {
	return new Promise (function (resolve) {
		moneyInstance.methods._maxSupply().call().then(result => {
			result = result ? result : 0;
			resolve(result);
		});
	});
}


async function getBalanceOf(accounts) {
	return new Promise (function (resolve) {
		moneyInstance.methods.balanceOf(accounts[0]).call().then(result => {
			result = result ? result : 0;
			resolve(result);
		});
	});
}


async function getTokenFrozenBalances(accounts) {
	return new Promise (function (resolve) {
		moneyInstance.methods.tokenFrozenBalances(accounts[0]).call().then(result => {
			result = result ? result : 0;
			resolve(result);
		});
	});
}

async function getFreezingReward(accounts) {
	return new Promise (function (resolve) {
		moneyInstance.methods.calcFreezingRewards().call({from: accounts[0]}).then(result => {
			result = result ? result : 0;
			resolve(result);
		});
	});
}


async function getAllowance(accounts) {
	return new Promise (function (resolve) {
		tokenInstance.methods.allowance(accounts[0], moneyAddress).call().then(result => {
			result = result ? result : 0;
			resolve(result);
		});
	});
}


async function getLockedToken() {
	return new Promise (function (resolve) {
		moneyInstance.methods.lockedTokens().call().then(result => {
			result = result ? result : 0;
			resolve(result);
		});
	});
}

async function getFrzoneTokenBalance() {
	return new Promise (function (resolve) {
		moneyInstance.methods.totalFrozenTokenBalance().call().then(result => {
			result = result ? result : 0;
			resolve(result);
		});
	});
}

async function getHxyTransformed() {
	return new Promise (function (resolve) {
		moneyInstance.methods.totalHXYTransformed().call().then(result => {
			result = result ? result : 0;
			resolve(result);
		});
	});
}

async function getHeartsTransformed() {
	return new Promise (function (resolve) {
		moneyInstance.methods.totalHeartsTransformed().call().then(result => {
			result = result ? result : 0;
			resolve(result);
		});
	});
}



function getMeta(metaName) {
  const metas = document.getElementsByTagName('meta');

  for (let i = 0; i < metas.length; i++) {
    if (metas[i].getAttribute('name') === metaName) {
      return metas[i].getAttribute('content');
    }
  }

  return '';
}


function etherscanPost() {

	if (accounts && accounts.length > 0) {
		xhttp.open("POST", "includes/etherscan.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("account="+accounts[0]+"&token="+getMeta("_csrf"));

		xhttp.onreadystatechange = function() {

		    if (this.readyState === 4 && this.status === 200) {
		    	var response = this.responseText;

		    	var arr = JSON.parse(response);

		    	if (arr.status === 404) {
		    		return false;
		    	}

			    var divs = arr.stats;
			    var total = arr.total;

			    if(divs === 0){
			    	document.getElementById("your_airdropped_divs").style = "color:red";
			    	document.getElementById("your_airdropped_divs").innerHTML = "**********";	
			    }
			    else {
					divs = divs / 100000000;	
				    divs = divs.toLocaleString('en-GB');		    	
			    	document.getElementById("your_airdropped_divs").style = "";
					document.getElementById("your_airdropped_divs").innerHTML = divs + " HXY";
			    }
			   	if(total === 0){
			    	document.getElementById("total_approved").innerHTML = "**********";	
			    	document.getElementById("total_approved").style = "color:red";
			   	}
			   	else {
			   		total = total / 100000000;	
			   		total = total.toLocaleString('en-GB');
					document.getElementById("total_approved").innerHTML = total + " HXY";
					document.getElementById("total_approved").style = "";		   		
			   	}

		    }
		};	

	}

}			  