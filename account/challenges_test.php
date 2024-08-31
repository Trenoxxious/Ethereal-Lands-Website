<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="new_account.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <title>Document</title>
</head>

<body>
    <div id="challenges-container">
        <div class="challenge-box epic-border">
            <h3 class="challenge-title epic">Mine Ore</h3>
            <p>Epic Challenge</p>
            <p class="challenge-info">Mining any ore while this challenge is active will count toward completing this challenge.</p>
            <p id="1" class="challenge-stats">Progress 6/60</p>
            <p class="challenge-reward">Reward: 60<img src="../images/soul.png" alt="Souls"></p>
            <form id="complete-challenge-form-${challenge.id}" class="complete-challenge-form" method="post">
                <input type="hidden" name="challenge_id" value="${challenge.id}">
                <button id="claim-button-${challenge.id}" type="submit" class="button-main" ${parseInt(challenge.value) < parseInt(challenge.fulfillment_amount) ? 'disabled' : ''}>Complete Challenge</button>
            </form>
        </div>
    </div>
</body>

</html>