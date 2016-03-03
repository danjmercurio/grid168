class CreateSubChannels < ActiveRecord::Migration
  def change
    create_table :sub_channels do |t|
      t.integer :sub_channel_type_id
      t.string :first_name
      t.string :last_name
      t.integer :subs
      t.integer :outlet_id

      t.timestamps
    end
  end
end
