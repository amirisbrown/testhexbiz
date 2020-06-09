let accounts;
var xhttpEtherscan = new XMLHttpRequest();
var xhttpEthernum = new XMLHttpRequest();
var freezeEndDate = 0;

async function getAccounts() {
  accounts = await web3.eth.getAccounts();
  etherscanPost();
  metamaskPost();
}

if (window.ethereum) {
  window.ethereum.enable();
  getAccounts();
  setInterval(() => getAccounts(), 60000);
}

function getMeta(metaName) {
  const metas = document.getElementsByTagName("meta");

  for (let i = 0; i < metas.length; i++) {
    if (metas[i].getAttribute("name") === metaName) {
      return metas[i].getAttribute("content");
    }
  }

  return "";
}

function etherscanPost() {
  if (accounts && accounts.length > 0) {
    xhttpEtherscan.open("POST", "includes/etherscan.php", true);
    xhttpEtherscan.setRequestHeader(
      "Content-type",
      "application/x-www-form-urlencoded"
    );
    xhttpEtherscan.send(
      "account=" + accounts[0] + "&token=" + getMeta("_csrf")
    );

    xhttpEtherscan.onreadystatechange = function () {
      if (this.readyState === 4 && this.status === 200) {
        var response = this.responseText;
        var arr = JSON.parse(response);

        if (arr.status === 404) {
          return false;
        }

        var divs = arr.stats ? arr.stats : 0;
        var total = arr.total ? arr.total : 0;

        if (divs === 0) {
          document
            .getElementById("your_airdropped_divs")
            .classList.add("invalid");
          document.getElementById("your_airdropped_divs").innerHTML =
            "**********";
        } else {
          divs = divs / 100000000;
          divs = divs.toLocaleString("en-GB");
          document
            .getElementById("your_airdropped_divs")
            .classList.remove("invalid");
          document.getElementById("your_airdropped_divs").innerHTML =
            divs + " HXY";
        }
        if (total === 0) {
          document.getElementById("total_approved").innerHTML = "**********";
          document.getElementById("total_approved").style = "color:red";
        } else {
          total = total / 100000000;
          total = total.toLocaleString("en-GB");
          document.getElementById("total_approved").innerHTML = total + " HXY";
          document.getElementById("total_approved").style = "";
        }
      }
    };
  }
}

function countdownTimerFreeze(ebdDate, id) {
  if (ebdDate) {
    var countDownDate = new Date(ebdDate).getTime();
    var x = setInterval(function () {
      var now = new Date().getTime();
      var distance = countDownDate - now;
      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = Math.floor(
        (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
      );
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);
      document.getElementById(id).innerHTML =
        days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
      if (distance < 0) {
        clearInterval(x);
      }
    }, 1000);
  }
}

function metamaskPost() {
  if (accounts && accounts.length > 0) {
    xhttpEthernum.open("POST", "includes/ethereum.php", true);
    xhttpEthernum.setRequestHeader(
      "Content-type",
      "application/x-www-form-urlencoded"
    );
    xhttpEthernum.send("account=" + accounts[0] + "&token=" + getMeta("_csrf"));

    xhttpEthernum.onreadystatechange = function () {
      if (this.readyState === 4 && this.status === 200) {
        var response = this.responseText;
        var arr = JSON.parse(response);
        let balanceOf = arr.accountBalance;
        let tokenFrozenBalances = arr.frozenBalances;
        let freezingReward = arr.freezingReward;
        let allowance = arr.allowance;
        let totalSupply = arr.totalSupply;
        let maxSupply = arr.maxSupply;
        let lockedToken = arr.lockedToken;
        let frzoneTokenBalance = arr.freezeTokenBalance;
        let hxyTransformed = arr.hxyTransformed;
        let heartsTransformed = arr.heartsTransformed;
        freezeEndDate = arr.freezeEndDate;

        if (parseInt(freezeEndDate) > 0) {
          freezeEndDate = parseInt(parseInt(freezeEndDate) * 1000 + 604800000);
          countdownTimerFreeze(freezeEndDate, "freeze_end");
        }

        countdownTimerFreeze(new Date().setUTCHours(24, 0, 0, 0), "aa_end");

        allowance = allowance / 100000000 ?? 0;
        hxyTransformed = hxyTransformed / 100000000 ?? 0;
        heartsTransformed = heartsTransformed / 100000000 ?? 0;
        tokenFrozenBalances = tokenFrozenBalances / 100000000 ?? 0;
        balanceOf = balanceOf / 100000000 ?? 0;

        let interest =
          tokenFrozenBalances === 0 ? 0 : freezingReward / 100000000 ?? 0;
        interest = interest ? interest.toLocaleString("en-GB") : 0;

        let calculating_supply =
          (totalSupply / 100000000 ?? 0) -
          (frzoneTokenBalance / 100000000 ?? 0) -
          (lockedToken / 100000000 ?? 0);
        totalSupply = Math.floor(totalSupply / 100000000 ?? 0);
        totalSupply = totalSupply.toLocaleString("en-GB");
        lockedToken = lockedToken / 100000000 ?? 0;
        lockedToken = lockedToken.toLocaleString("en-GB");
        frzoneTokenBalance = frzoneTokenBalance / 100000000 ?? 0;
        frzoneTokenBalance = frzoneTokenBalance.toLocaleString("en-GB");
        calculating_supply = calculating_supply.toLocaleString("en-GB");
        tokenFrozenBalances = tokenFrozenBalances.toLocaleString("en-GB");
        hxyTransformed = hxyTransformed.toLocaleString("en-GB");
        heartsTransformed = heartsTransformed.toLocaleString("en-GB");
        maxSupply = maxSupply / 100000000 ?? 0;
        maxSupply = maxSupply.toLocaleString("en-GB");

        let refereal_url = window.location.origin + "&#47;?r=" + accounts[0];

        document.getElementById("balance").innerHTML =
          balanceOf.toLocaleString("en-GB") + " HXY";
        document.getElementById("total_supply").innerHTML =
          totalSupply + " HXY";
        document.getElementById("locked_tokens").innerHTML =
          lockedToken + " HXY";
        document.getElementById("frzoneTokenBalance").innerHTML =
          frzoneTokenBalance + " HXY";
        document.getElementById("calculating_supply").innerHTML =
          calculating_supply + " HXY";
        document.getElementById("approved_amount").innerHTML =
          allowance + " HEX";
        document.getElementById("interest").innerHTML = interest + " HXY";
        document.getElementById("tokenFrozenBalances").innerHTML =
          tokenFrozenBalances + " HXY";
        document.getElementById("maxSupply").innerHTML = maxSupply + " HXY";
        document.getElementById("total_hxy_conversion").innerHTML =
          hxyTransformed + " HXY";
        document.getElementById("total_hex_conversion").innerHTML =
          heartsTransformed + " HXY";

        document.getElementById("referal_url").innerHTML = refereal_url;
      }
    };
  }
}
