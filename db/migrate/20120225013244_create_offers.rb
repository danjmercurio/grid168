class CreateOffers < ActiveRecord::Migration
  def change
    create_table :offers do |t|
      t.float :value_per_subscribe
      t.integer :programmer_id
      t.integer :outlet_id
      t.float :yearly_offer
      t.float :monthly_offer
      t.float :weekly_offer
      t.float :hourly_rate
      t.float :hours

      t.timestamps
    end
  end
end
