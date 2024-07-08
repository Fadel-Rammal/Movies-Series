import datetime
import math
import pymysql

# Function to connect to the database
def connect_to_database():
    try:
        conn = pymysql.connect(host='localhost', user='root', password='', database='Movies&Series')
        return conn
    except pymysql.MySQLError as e:
        print(f"Error connecting to database: {e}")
        return None

# Function to deduct coins and update user status
def deduct_coins(user_id, start_subscription, credits, deduction_time, current_datetime, set_inactive=False):
    if deduction_time is None:
        deduction_time = start_subscription

    time_since_last_deduction = (current_datetime - deduction_time).total_seconds() / 3600
    coins_to_deduct = math.ceil(time_since_last_deduction)

    new_credits = credits - coins_to_deduct
    if new_credits < 24:
        status = 'inactive'
    else:
        status = 'inactive' if set_inactive else 'active'

    update_balance_query = (f"UPDATE userinfo SET credits = {new_credits}, deduction_time = '{current_datetime}', "
                            f"status = '{status}', end_subscription_today = 0 WHERE id = {user_id}")
    return update_balance_query, status, coins_to_deduct

# Function to check and update subscription status for users with end_subscription
def check_subscription_status(cursor, current_datetime):
    try:
        query = "SELECT id, start_subscription, end_subscription FROM userinfo WHERE status = 'active' AND end_subscription IS NOT NULL"
        cursor.execute(query)
        active_users = cursor.fetchall()

        users_affected = 0

        for user in active_users:
            user_id, start_subscription, end_subscription = user
            
            if current_datetime > end_subscription:
                update_query = "UPDATE userinfo SET status = 'inactive', end_subscription = NULL, deduction_time = NULL WHERE id = %s"
                cursor.execute(update_query, (user_id,))
                print(f"User {user_id} subscription has expired. Status updated to 'inactive'.")
                users_affected += 1

        if users_affected == 0:
            print("No one month users were affected.")
        else:
            print(f"{users_affected} one month subscription user(s) were updated to 'inactive'.")

    except Exception as e:
        print("Error:", e)

# Main function to handle the overall logic
def main():
    conn = connect_to_database()
    if conn is None:
        return

    cursor = conn.cursor()
    current_datetime = datetime.datetime.now()
    deductions_made = False

    # Check and update subscription status for users with end_subscription
    check_subscription_status(cursor, current_datetime)

    # Deduct coins for users with daily deduction enabled and end_subscription_today set to 1
    query = "SELECT id, start_subscription, credits, deduction_time FROM userinfo WHERE status = 'active' AND end_subscription IS NULL AND end_subscription_today = 1"
    cursor.execute(query)
    active_subscriptions = cursor.fetchall()

    for user_id, start_subscription, credits, deduction_time in active_subscriptions:
        update_balance_query, status, coins_to_deduct = deduct_coins(user_id, start_subscription, credits, deduction_time, current_datetime, set_inactive=True)
        try:
            cursor.execute(update_balance_query)
            conn.commit()
            print(f"Deducted {coins_to_deduct} coins from user ID {user_id}: Success")
            if status == 'inactive':
                print(f"User ID {user_id} set to inactive.")
            deductions_made = True
        except Exception as e:
            print(f"Deduction for user ID {user_id}: Failed - {str(e)}")

    # Deduct coins for users with daily deduction enabled and end_subscription_today set to 0
    query = "SELECT id, start_subscription, credits, deduction_time FROM userinfo WHERE status = 'active' AND end_subscription IS NULL AND end_subscription_today = 0"
    cursor.execute(query)
    active_subscriptions = cursor.fetchall()

    for user_id, start_subscription, credits, deduction_time in active_subscriptions:
        update_balance_query, status, coins_to_deduct = deduct_coins(user_id, start_subscription, credits, deduction_time, current_datetime, set_inactive=False)
        try:
            cursor.execute(update_balance_query)
            conn.commit()
            print(f"Deducted {coins_to_deduct} coins from user ID {user_id}: Success")
            if status == 'inactive':
                print(f"User ID {user_id} set to inactive.")
            deductions_made = True
        except Exception as e:
            print(f"Deduction for user ID {user_id}: Failed - {str(e)}")

    if not deductions_made:
        print("No deduction happened.")

    cursor.close()
    conn.close()

if __name__ == "__main__":
    main()
