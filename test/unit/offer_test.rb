# == Schema Information
#
# Table name: offers
#
#  id                :integer(4)      not null, primary key
#  outlet_id         :integer(4)
#  yearly_offer      :float           default(0.0), not null
#  monthly_offer     :float           default(0.0), not null
#  weekly_offer      :float           default(0.0), not null
#  hourly_rate       :float           default(0.0), not null
#  total_hours       :float           default(0.0), not null
#  created_at        :datetime
#  updated_at        :datetime
#  dollar_amount     :float           default(0.0), not null
#  half_hour_clicked :text
#  user_id           :integer(4)
#

require 'test_helper'

class OfferTest < ActiveSupport::TestCase
  # test "the truth" do
  #   assert true
  # end
end
