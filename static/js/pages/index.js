let isFreeze = true;
var xhttpapprove = new XMLHttpRequest();
var xhttptransform = new XMLHttpRequest();
var xhttpproceed = new XMLHttpRequest();

document.addEventListener("DOMContentLoaded", pageReady);

function pageReady() {
  document.getElementById("enter-amount").removeAttribute("disabled");
  document.getElementById("freeze-amount").removeAttribute("disabled");
  document.getElementById("modal-amount").removeAttribute("disabled");
}

document.getElementById("transform").addEventListener("click", function (e) {
  e.preventDefault();
  if (window.ethereum) {
    window.ethereum.enable();

    if (accounts && accounts.length > 0) {
      let amount = document.getElementById("enter-amount").value;
      if (amount) {
        var weiAmout = Math.floor(amount * 100000000);

        if (weiAmout > 0) {
          xhttptransform.open("POST", "includes/transaction.php", true);
          xhttptransform.setRequestHeader(
            "Content-type",
            "application/x-www-form-urlencoded"
          );
          xhttptransform.send(
            "account=" + accounts[0] + "&type=transform&amount=" + weiAmout
          );

          xhttptransform.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
              console.log("Response", this.responseText);
              if (this.responseText == "success")
                showSuccess("transform", amount);
              document.getElementById("enter-amount").value = "";
            }
          };
        } else {
          showNodata("transform");
        }
      } else {
        showNodata("transform");
      }
    } else {
      showMetamaskLogin();
    }
  } else {
    showMetamaskLogin();
  }
});

document.getElementById("enter-amount").addEventListener("keyup", function (e) {
  const amount = document.getElementById("enter-amount").value;
  document.getElementById("canreceive").innerHTML =
    parseInt(amount || 0) / 1000 || 0 + " HXY";
});

document.getElementById("proceed").addEventListener("click", function (e) {
  e.preventDefault();
  if (window.ethereum) {
    window.ethereum.enable();

    if (accounts && accounts.length > 0) {
      let amount = document.getElementById("freeze-amount").value;

      if (amount) {
        var weiAmout = Math.floor(amount * 100000000);

        if (weiAmout > 0) {
          xhttpproceed.open("POST", "includes/transaction.php", true);
          xhttpproceed.setRequestHeader(
            "Content-type",
            "application/x-www-form-urlencoded"
          );
          if (isFreeze) {
            xhttpproceed.send(
              "account=" + accounts[0] + "&type=freeze&amount=" + weiAmout
            );
          } else {
            xhttpproceed.send("account=" + accounts[0] + "&type=unfreeze");
          }

          xhttpproceed.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
              console.log(this.responseText);
              if (this.responseText == "success")
                showSuccess("freeze", weiAmout);
              document.getElementById("freeze-amount").value = "";
            }
          };

          document.getElementById("freeze-amount").value = "";
        } else {
          showNodata("freeze");
        }
      } else {
        showNodata("freeze");
      }
    } else {
      showMetamaskLogin();
    }
  } else {
    showMetamaskLogin();
  }
});

// function freeze(amount) {
//   moneyInstance.methods
//     .FreezeTokens(amount)
//     .send({ from: accounts[0] })
//     .then(showSuccess("freeze", amount));
// }

// function unfreeze(amount) {
//   moneyInstance.methods
//     .UnfreezeTokens()
//     .send({ from: accounts[0] })
//     .then(showSuccess("unfreeze", amount));
// }

document.getElementById("approve").addEventListener("click", function (e) {
  e.stopPropagation();

  showModal();
});

document
  .getElementById("approvemobile")
  .addEventListener("click", function (e) {
    e.stopPropagation();
    showModal();
  });

document.getElementById("freeze").addEventListener("click", function (e) {
  document.getElementById("freeze").classList.add("active");
  isFreeze = true;
  document.getElementById("unfreeze").classList.remove("active");
});

document.getElementById("unfreeze").addEventListener("click", function (e) {
  isFreeze = false;
  document.getElementById("unfreeze").classList.add("active");
  document.getElementById("freeze").classList.remove("active");
});

document.getElementById("modal_close").addEventListener("click", hideModal);
document.getElementById("modal-back").addEventListener("click", hideModal);
document.getElementById("btn_approve").addEventListener("click", approveHex);

function approveHex(e) {
  e.preventDefault();
  let amount = document.getElementById("modal-amount").value;

  if (amount) {
    var weiAmout = Math.floor(amount * 100000000);

    if (weiAmout > 0) {
      if (accounts && accounts.length > 0) {
        xhttpapprove.open("POST", "includes/transaction.php", true);
        xhttpapprove.setRequestHeader(
          "Content-type",
          "application/x-www-form-urlencoded"
        );
        xhttpapprove.send(
          "account=" + accounts[0] + "&type=approve&amount=" + weiAmout
        );

        xhttpapprove.onreadystatechange = function () {
          if (this.readyState === 4 && this.status === 200) {
            showSuccess("approve", weiAmout);
            document.getElementById("modal-amount").value = "";
          }
        };
      } else {
        showMetamaskLogin();
      }
    } else {
      showNodata("approve");
    }
  } else {
    showNodata("approve");
  }
}

function showNodata(type) {
  Swal.fire({
    icon: "error",
    title: "Oops...",
    html: "<div>" + no_input + "</div>"
  });
}

function showModal() {
  if (window.ethereum) {
    window.ethereum.enable();
    document.getElementById("approve_token_modal").style.display = "block";
    document.getElementById("modal-back").className = "ismodal";
  } else {
    showMetamaskLogin();
  }
}

function showSuccess(type, amount) {
  let message = in_processing;

  if (type == "approve") {
    hideModal();
  }

  Swal.fire({
    icon: "success",
    title: "Thanks",
    html: "<div>" + message + "</div>"
  });
}

function hideModal() {
  document.getElementById("modal-amount").value = "";
  document.getElementById("modal-back").className = "";
  document.getElementById("approve_token_modal").style.display = "none";
}

function removeSpaces(value) {
  if (value == "") {
    document.getElementById("email").value = "***";
    document.getElementById("email").value = "";
  }
  var newVal = value.replace(/\s/g, "");

  document.getElementById("email").value = newVal;
}

function setCaretPosition(elemId, caretPos) {
  var elem = document.getElementById(elemId);

  if (elem != null) {
    if (elem.createTextRange) {
      var range = elem.createTextRange();
      range.move("character", caretPos);
      range.select();
    } else {
      if (elem.selectionStart) {
        elem.focus();
        elem.setSelectionRange(caretPos, caretPos);
      } else elem.focus();
    }
  }
}

function showMetamaskLogin() {
  Swal.fire({
    icon: "error",
    title: "Oops...",
    html: "<div>" + no_metamask + "</div>"
  });
}

ValidateEmail = function (evt) {
  const re = /^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;

  if (re.test(document.getElementById("email").value)) {
    return true;
  }

  Swal.fire({
    icon: "error",
    title: "Oops...",
    html: "<div>" + entered_invalid_email + "</div>"
  });

  evt.preventDefault();
  return false;
};

document.getElementById("emailForm").addEventListener("submit", ValidateEmail);

document.getElementById("email").addEventListener("change", function () {
  document.getElementById("email").value = document
    .getElementById("email")
    .value.replace(/\s/g, "");
});
