class DeviceForAdmin < ActiveRecord::Migration
  def up
    create_table :admins do |t|
      t.string :email
      t.string :encrypted_password
      t.timestamps
    end
  end

  def down
    drop_table :admins
  end
end
