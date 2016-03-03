class CreateSubChannelOffers < ActiveRecord::Migration
  def change
    create_table :sub_channel_offers do |t|
      t.float :yearly_offer, :default => 0.0, :null => false
      t.float :monthly_offer, :default => 0.0, :null => false
      t.float :weekly_offer, :default => 0.0, :null => false
      t.float :hourly_rate, :default => 0.0, :null => false
      t.float :total_hours, :default => 0.0, :null => false
      t.float :dollar_amount, :default => 0.0, :null => false
      t.text :half_hour_clicked
      t.integer :sub_channel_id

      t.timestamps
    end
  end
end
